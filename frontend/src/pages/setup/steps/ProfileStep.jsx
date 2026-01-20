import SetupProgress from './../../../components/SetupProgress';

export default function ProfileStep({ data, onNext, step, total }) {
    return (
        <>
            <SetupProgress step={step} total={total} />

            <h2 className="text-xl font-semibold">About you</h2>

            <input
                placeholder="Name (optional)"
                defaultValue={data.name}
                className="w-full px-3 py-2 border rounded-md"
            />

            <input
                placeholder="Email (optional)"
                defaultValue={data.email}
                className="w-full px-3 py-2 border rounded-md"
            />

            <button
                onClick={() => onNext()}
                className="w-full py-2 text-white bg-blue-500 rounded-md"
            >
                Continue
            </button>

            <button
                onClick={() => onNext()}
                className="w-full text-sm text-gray-500"
            >
                Skip
            </button>
        </>
    );
}
