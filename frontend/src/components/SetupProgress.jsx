export default function SetupProgress({ step, total }) {
    return (
        <p className="text-xs text-gray-400">
            Step {step} of {total}
        </p>
    );
}