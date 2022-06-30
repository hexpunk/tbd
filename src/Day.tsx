import clsx from "clsx";

export default function Day({ date }: { date: Date }) {
  return (
    <button
      type="button"
      className={clsx(
        "h-20 w-20 rounded-sm bg-stone-100",
        "focus:bg-emerald-200 focus:outline-none focus:ring focus:ring-emerald-500",
        "active:bg-emerald-500",
      )}
    >
      {date.getDate()}
    </button>
  );
}
