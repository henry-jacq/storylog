import SetupProgress from './../../../components/SetupProgress';

export default function DoneStep({ onFinish, step, total }) {
    return (
        <>
            <SetupProgress step={step} total={total} />

            <h2 className="text-xl font-semibold">You're all set 🎉</h2>

            <p className="text-sm text-gray-600">
                Storylog is ready. Your journals stay private and local.
            </p>

            <button
                onClick={onFinish}
                className="w-full py-2 text-white bg-blue-500 rounded-md"
            >
                Start Writing
            </button>
        </>
    );
}
