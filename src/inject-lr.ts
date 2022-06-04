declare const TINYLR_PORT: number;
declare const ENVIRONMENT: string | undefined;

if (ENVIRONMENT === "development") {
  const script = document.createElement("script");
  script.src = `//${window.location.hostname}:${TINYLR_PORT}/livereload.js`;
  document.body.appendChild(script);
}

export {};
