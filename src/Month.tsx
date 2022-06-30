import Day from "./Day";

export default function Month({
  year,
  month,
}: {
  year: number;
  month: number;
}) {
  const days = new Date(year, month + 1, 0).getDate();

  return (
    <div className="bg-stone-500 w-max p-1.5 grid grid-cols-7 gap-1.5">
      {new Array(days).fill(null).map((_, index) => {
        const date = new Date(year, month, index + 1);

        return <Day key={date.getTime()} date={date} />;
      })}
    </div>
  );
}
