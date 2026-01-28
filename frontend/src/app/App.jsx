import { BrowserRouter, useNavigate, useLocation } from "react-router-dom";
import { useEffect, useState, useRef, useCallback } from "react";
import Router from "./Router";
import { SettingsAPI } from "../services/settings";
import { clearSessionToken } from "../services/api";
import AppLock from "../pages/AppLock";

// Constants for app lock timeout
const APP_LOCK_TIMEOUT = 5 * 60 * 1000; // 5 minutes in milliseconds
const ACTIVITY_EVENTS = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'];
const SESSION_KEY = 'storylog_unlocked';

function AppGuard() {
    const navigate = useNavigate();
    const location = useLocation();

    const [checked, setChecked] = useState(false);
    const [locked, setLocked] = useState(false);
    const [hasAppLock, setHasAppLock] = useState(false);
    
    const timeoutRef = useRef(null);
    const lastActivityRef = useRef(Date.now());

    // Session storage helpers
    const isSessionUnlocked = useCallback(() => {
        try {
            const sessionData = sessionStorage.getItem(SESSION_KEY);
            if (!sessionData) return false;
            
            const { timestamp, lastActivity } = JSON.parse(sessionData);
            const now = Date.now();
            
            // Check if session expired due to timeout
            if (now - lastActivity > APP_LOCK_TIMEOUT) {
                sessionStorage.removeItem(SESSION_KEY);
                return false;
            }
            
            // Update last activity time
            sessionStorage.setItem(SESSION_KEY, JSON.stringify({
                timestamp,
                lastActivity: now
            }));
            
            return true;
        } catch {
            return false;
        }
    }, []);

    const setSessionUnlocked = useCallback(() => {
        try {
            sessionStorage.setItem(SESSION_KEY, JSON.stringify({
                timestamp: Date.now(),
                lastActivity: Date.now()
            }));
        } catch {
            // Fallback if sessionStorage is not available
        }
    }, []);

    const clearSessionUnlocked = useCallback(() => {
        try {
            sessionStorage.removeItem(SESSION_KEY);
            // Also clear the session token when app locks
            clearSessionToken();
        } catch {
            // Ignore errors
        }
    }, []);

    // Reset the app lock timeout
    const resetTimeout = useCallback(() => {
        if (timeoutRef.current) {
            clearTimeout(timeoutRef.current);
        }
        
        if (hasAppLock && !locked) {
            timeoutRef.current = setTimeout(() => {
                setLocked(true);
                clearSessionUnlocked();
            }, APP_LOCK_TIMEOUT);
        }
    }, [hasAppLock, locked, clearSessionUnlocked]);

    // Handle user activity
    const handleUserActivity = useCallback(() => {
        const now = Date.now();
        lastActivityRef.current = now;
        
        // Update session storage with new activity time
        if (hasAppLock && !locked) {
            try {
                const sessionData = sessionStorage.getItem(SESSION_KEY);
                if (sessionData) {
                    const { timestamp } = JSON.parse(sessionData);
                    sessionStorage.setItem(SESSION_KEY, JSON.stringify({
                        timestamp,
                        lastActivity: now
                    }));
                }
            } catch {
                // Ignore errors
            }
        }
        
        resetTimeout();
    }, [hasAppLock, locked, resetTimeout]);

    // Setup activity listeners
    useEffect(() => {
        if (hasAppLock && !locked) {
            ACTIVITY_EVENTS.forEach(event => {
                document.addEventListener(event, handleUserActivity);
            });
            
            // Initial timeout setup
            resetTimeout();

            return () => {
                ACTIVITY_EVENTS.forEach(event => {
                    document.removeEventListener(event, handleUserActivity);
                });
                if (timeoutRef.current) {
                    clearTimeout(timeoutRef.current);
                }
            };
        }
    }, [hasAppLock, locked, handleUserActivity, resetTimeout]);

    // Manual app-lock trigger
    useEffect(() => {
        if (location.state?.lockNow) {
            setLocked(true);
            clearSessionUnlocked();

            // clear navigation state to avoid re-lock loops
            navigate(location.pathname, { replace: true });
        }
    }, [location, navigate, clearSessionUnlocked]);

    // Initial settings check (ONLY ON FIRST MOUNT)
    useEffect(() => {
        let alive = true;

        (async () => {
            try {
                const data = await SettingsAPI.getPublic();
                if (!alive) return;

                if (!data.is_initialized) {
                    setChecked(true);
                    navigate("/setup", { replace: true });
                    return;
                }

                // Check if app lock is enabled
                const appLockEnabled = data.app_lock_enabled;
                setHasAppLock(appLockEnabled);
                
                if (appLockEnabled) {
                    // Check if already unlocked in this session
                    const isCurrentlyUnlocked = isSessionUnlocked();
                    setLocked(!isCurrentlyUnlocked);
                } else {
                    setLocked(false);
                }
                
                setChecked(true);
            } catch (e) {
                console.error("Settings load failed", e);
                setChecked(true);
            }
        })();

        return () => {
            alive = false;
        };
    }, []); // Empty dependency array to run only once on mount

    // Handle unlock
    const handleUnlock = useCallback(() => {
        setLocked(false);
        lastActivityRef.current = Date.now();
        setSessionUnlocked();
    }, [setSessionUnlocked]);

    if (!checked) return null;

    if (locked) {
        return <AppLock onUnlock={handleUnlock} />;
    }

    return <Router />;
}

export default function App() {
    return (
        <BrowserRouter>
            <AppGuard />
        </BrowserRouter>
    );
}
