const chokidar = require("chokidar");
const esbuild = require("esbuild");
const tinylr = require("tiny-lr");

const tinylrOptions = {
  host: "0.0.0.0",
  port: 35729,
};

const esbuildServerOptions = {
  port: 8000,
  host: "0.0.0.0",
  servedir: "public",
  onRequest: ({ remoteAddress, method, path, status, timeInMS }) => {
    console.log(
      `${remoteAddress} - "${method} ${path}" ${status} [${timeInMS}ms]`,
    );
  },
};

const esbuildOptions = {
  bundle: true,
  entryPoints: ["src/entry.ts"],
  outdir: "public/js",
  sourcemap: "linked",
  define: {
    ENVIRONMENT: JSON.stringify(process.env.NODE_ENV ?? "development"),
    TINYLR_PORT: tinylrOptions.port,
  },
};

esbuild.serve(esbuildServerOptions, esbuildOptions).then(() => {
  const { port } = esbuildServerOptions;

  console.log(`Local: http://localhost:${port}/`);

  new tinylr.Server().listen(tinylrOptions.port, () => {
    const { host, port } = tinylrOptions;

    console.log(`Live Reload: http://localhost:${port}/`);

    chokidar.watch("src/**/*").on("all", (event, path) => {
      const verbs = {
        add: "Added",
        addDir: "Added",
        change: "Changed",
        unlink: "Removed",
        unlinkDir: "Removed",
      };

      console.log(`${verbs[event]} "${path}", reloading...`);

      fetch(`http://${host}:${port}/changed`, {
        method: "POST",
        headers: new Headers({ "Content-Type": "application/json" }),
        body: JSON.stringify({ files: [path] }),
      });
    });
  });
});
