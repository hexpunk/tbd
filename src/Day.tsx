export default function Day({ date }: { date: Date }) {
  return (
    <button
      type="button"
      className="bg-stone-100 h-20 w-20 rounded-sm focus:outline-none focus:ring focus:ring-emerald-500 focus:bg-emerald-200 active:bg-emerald-500"
    >
      {date.getDate()}
    </button>
  );
}
