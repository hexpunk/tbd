module.exports = {
  semi: true,
  trailingComma: "all",
  overrides: [
    {
      files: "*.json",
      options: {
        parser: "babel",
      },
    },
  ],
  plugins: [require("prettier-plugin-tailwindcss")],
};
