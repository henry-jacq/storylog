export function getNowMeta() {
    const now = new Date();

    const date = now.toISOString().slice(0, 10);

    const time = now.toTimeString().slice(0, 8);

    const day = now.toLocaleDateString("en-US", { weekday: "long" });

    const start = new Date(now.getFullYear(), 0, 0);
    const diff =
        now - start +
        (start.getTimezoneOffset() - now.getTimezoneOffset()) * 60 * 1000;
    const dayOfYear = Math.floor(diff / (1000 * 60 * 60 * 24));

    return { date, time, day, dayOfYear };
}
