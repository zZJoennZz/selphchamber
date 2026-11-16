// Compiles every entry in ENTRIES with the Tailwind v4 CLI.
// Add a new page-specific file: drop it in src/css/ and add one line here.
import { execFileSync } from "node:child_process";
import { existsSync, mkdirSync } from "node:fs";

const WATCH = process.argv.includes("--watch");

const ENTRIES = [
  { input: "src/css/globals.css", output: "assets/css/globals.css" },
  { input: "src/css/home.css",    output: "assets/css/home.css" },
  { input: "src/css/page.css",    output: "assets/css/page.css" },
  { input: "src/css/single.css",  output: "assets/css/single.css" },
  { input: "src/css/archive.css", output: "assets/css/archive.css" },
];

mkdirSync("assets/css", { recursive: true });

for (const { input, output } of ENTRIES) {
  if (!existsSync(input)) {
    console.warn(`Skipping missing entry: ${input}`);
    continue;
  }
  const args = ["@tailwindcss/cli", "-i", input, "-o", output];
  if (WATCH) args.push("--watch");
  console.log(`${WATCH ? "Watching" : "Building"} ${input} -> ${output}`);
  execFileSync("npx", args, { stdio: "inherit" });
}
