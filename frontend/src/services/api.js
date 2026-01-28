/**
 * API Service Configuration and Utilities
 * 
 * This module provides the core API functionality including:
 * - Session token management
 * - Request/response handling
 * - Error handling
 * - Authentication headers
 */

// Configuration
export const API_BASE = "http://127.0.0.1:8000";
const SESSION_TOKEN_KEY = 'storylog_session_token';

// Session Management
class SessionManager {
    static getToken() {
        try {
            return localStorage.getItem(SESSION_TOKEN_KEY);
        } catch {
            console.warn('Failed to access localStorage');
            return null;
        }
    }

    static setToken(token) {
        try {
            if (token) {
                localStorage.setItem(SESSION_TOKEN_KEY, token);
            }
        } catch (error) {
            console.warn('Failed to store session token:', error);
        }
    }

    static clearToken() {
        try {
            localStorage.removeItem(SESSION_TOKEN_KEY);
        } catch (error) {
            console.warn('Failed to clear session token:', error);
        }
    }
}

// Request Configuration
class RequestBuilder {
    static buildOptions(sessionToken, userOptions = {}) {
        const defaultOptions = {
            headers: {
                ...(sessionToken && { 'Authorization': `Bearer ${sessionToken}` })
            }
        };

        // Only set Content-Type for non-FormData requests
        if (!(userOptions.body instanceof FormData)) {
            defaultOptions.headers['Content-Type'] = 'application/json';
        }

        return {
            ...defaultOptions,
            ...userOptions,
            headers: {
                ...defaultOptions.headers,
                ...userOptions.headers
            }
        };
    }
}

// Error Handling
class APIError extends Error {
    constructor(message, status = null, response = null) {
        super(message);
        this.name = 'APIError';
        this.status = status;
        this.response = response;
    }
}

class ErrorHandler {
    static handleResponse(response, json) {
        if (!json.status) {
            const message = json.detail || json.message || "API Error";
            throw new APIError(message, response.status, json);
        }
        return json;
    }

    static handleNetworkError(error) {
        if (error instanceof APIError) {
            throw error;
        }
        
        if (error.name === 'TypeError' && error.message.includes('fetch')) {
            throw new APIError('Network error. Please check your connection.');
        }
        
        throw new APIError('An unexpected error occurred.');
    }
}

// Main API Request Function
export async function request(url, options = {}) {
    try {
        const sessionToken = SessionManager.getToken();
        const requestOptions = RequestBuilder.buildOptions(sessionToken, options);
        
        const response = await fetch(`${API_BASE}${url}`, requestOptions);
        const json = await response.json();
        
        ErrorHandler.handleResponse(response, json);
        
        // Return json.data if it exists, otherwise return the full response
        // This handles endpoints like unlock that return session_id directly
        return json.data || json;
        
    } catch (error) {
        return ErrorHandler.handleNetworkError(error);
    }
}

// Convenience Methods
export const api = {
    get: (url, options = {}) => request(url, { ...options, method: 'GET' }),
    post: (url, data, options = {}) => request(url, {
        ...options,
        method: 'POST',
        body: JSON.stringify(data)
    }),
    put: (url, data, options = {}) => request(url, {
        ...options,
        method: 'PUT',
        body: JSON.stringify(data)
    }),
    delete: (url, options = {}) => request(url, { ...options, method: 'DELETE' }),
    patch: (url, data, options = {}) => request(url, {
        ...options,
        method: 'PATCH',
        body: JSON.stringify(data)
    })
};

// Export session management functions for backward compatibility
export const getSessionToken = SessionManager.getToken;
export const setSessionToken = SessionManager.setToken;
export const clearSessionToken = SessionManager.clearToken;