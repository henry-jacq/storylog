import SetupProgress from './../../../components/SetupProgress';

export default function WelcomeStep({ onNext, step, total }) {
    return (
        <>
            <SetupProgress step={step} total={total} />

            <h1 className="text-2xl font-semibold">
                Welcome to Storylog
            </h1>

            <p className="text-sm text-gray-600">
                A quiet place to reflect, write, and understand your days.
            </p>

            <button
                onClick={() => onNext()}
                className="w-full py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600"
            >
                Get Started
            </button>
        </>
    );
}