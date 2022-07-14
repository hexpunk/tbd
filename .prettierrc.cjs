module.exports = {
  semi: true,
  trailingComma: "all",
  overrides: [
    {
      files: "*.json",
      options: {
        parser: "json5",
        quoteProps: "preserve",
        singleQuote: false,
        trailingComma: "none",
      },
    },
  ],
  plugins: [require("prettier-plugin-tailwindcss")],
};
