const tailwindConfig = require("./tailwind.config");

/** @type {import('postcss').Config} */
module.exports = {
  plugins: {
    tailwindcss: {},
    autoprefixer: {},
    ...(process.env.NODE_ENV === "production"
      ? {
          "@fullhuman/postcss-purgecss": {
            content: tailwindConfig.content,
            defaultExtractor: (content) =>
              content.match(/[\w-/:.]+(?<!:)/g) || [],
          },
        }
      : {}),
  },
};
