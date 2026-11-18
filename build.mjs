// Compiles every entry in ENTRIES with the Tailwind v4 CLI.
// Add a new page-specific file: drop it in src/css/ and add one line here.
//
// NOTE: we call the CLI via `node <cli-path>` directly instead of `npx`.
// On Windows, npx is an .cmd shim that spawn/execFileSync cannot launch
// (spawnSync npx ENOENT). Calling the entry file with process.execPath
// is also measurably faster — no npx resolution overhead per run.
import { spawn } from "node:child_process";
import { createRequire } from "node:module";
import { existsSync, mkdirSync } from "node:fs";
import { fileURLToPath, pathToFileURL } from "node:url";
import path from "node:path";

const WATCH = process.argv.includes("--watch");
const require = createRequire(import.meta.url);
const themeRoot = path.dirname(fileURLToPath(import.meta.url));

// Resolve the CLI's compiled entry, cross-platform and exports-map-proof:
// 1) direct relative path from the theme root (node_modules lives there)
// 2) require.resolve fallback
function resolveCli() {
  const distDir = path.join(themeRoot, "node_modules", "@tailwindcss", "cli", "dist");
  for (const name of ["index.mjs", "index.js"]) {
    const candidate = path.join(distDir, name);
    if (existsSync(candidate)) return candidate;
  }
  // Fallbacks: ask Node to resolve the package, then locate its bin.
  try {
    return require.resolve("@tailwindcss/cli");
  } catch {
    return path.join(distDir, "index.mjs");
  }
}
const cliPath = resolveCli();

const ENTRIES = [
  { input: "src/css/globals.css", output: "assets/css/globals.css" },
  { input: "src/css/home.css",    output: "assets/css/home.css" },
  { input: "src/css/page.css",    output: "assets/css/page.css" },
  { input: "src/css/single.css",  output: "assets/css/single.css" },
  { input: "src/css/archive.css", output: "assets/css/archive.css" },
  { input: "src/css/frontpage.css", output: "assets/css/frontpage.css" },
];

mkdirSync(path.join(themeRoot, "assets/css"), { recursive: true });

// In watch mode every compiler stays alive, so we must start them all
// concurrently (a blocking serial loop would hang on the first entry).
const children = ENTRIES
  .filter(({ input }) => {
    if (!existsSync(input)) console.warn(`Skipping missing entry: ${input}`);
    return existsSync(input);
  })
  .map(({ input, output }) => {
    const args = [cliPath, "-i", input, "-o", output];
    if (WATCH) args.push("--watch");
    console.log(`${WATCH ? "Watching" : "Building"} ${input} -> ${output}`);
    return spawn(process.execPath, args, { stdio: "inherit", cwd: themeRoot });
  });

if (!WATCH) {
  const codes = await Promise.all(
    children.map((c) => new Promise((resolve) => c.on("exit", resolve)))
  );
  const failed = codes.findIndex((code) => code !== 0);
  if (failed !== -1) process.exitCode = codes[failed];
}
