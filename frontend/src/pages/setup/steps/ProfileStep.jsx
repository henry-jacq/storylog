import { useState } from 'react';
import SetupProgress from './../../../components/SetupProgress';

export default function ProfileStep({ data, onNext, step, total }) {
    const [name, setName] = useState(data.name || "");
    const [email, setEmail] = useState(data.email || "");
    
    return (
        <>
            <SetupProgress step={step} total={total} />

            <h2 className="text-xl font-semibold">About you</h2>

            <input
                placeholder="Name (optional)"
                onChange={e => setName(e.target.value)}
                className="w-full px-3 py-2 border rounded-md"
            />

            <input
                placeholder="Email (optional)"
                onChange={e => setEmail(e.target.value)}
                className="w-full px-3 py-2 border rounded-md"
            />

            <button
                onClick={() => onNext({name, email})}
                className="w-full py-2 text-white bg-blue-500 rounded-md"
            >
                Continue
            </button>
        </>
    );
}
