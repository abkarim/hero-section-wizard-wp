import { execFileSync } from "node:child_process";
import fs from "node:fs/promises";
import path from "node:path";

const buildFolderName = "release";
const currentDir = process.cwd();
const buildDir = path.join(currentDir, buildFolderName);
const zipName = `${path.basename(currentDir)}.zip`;
const zipAbsolutePath = path.join(currentDir, zipName);

const excludeSet = new Set([
    buildFolderName,
    ".git",
    ".gitignore",
    ".github",
    "blocks",
    "extract.ts",
    "node_modules",
    "package.json",
    "package-lock.json",
    zipName,
]);

async function main() {
    console.log(`🧹 Cleaning old build directory: ${buildDir}`);
    await fs.rm(buildDir, { recursive: true, force: true });
    await fs.mkdir(buildDir, { recursive: true });

    console.log("🚚 Copying filtered project files...");
    const entries = await fs.readdir(currentDir);

    // Process copies in parallel instead of a sequential for...of loop
    await Promise.all(
        entries.map(async (entry) => {
            // Skip anything in our exclude list right at the start
            if (excludeSet.has(entry)) return;

            const source = path.join(currentDir, entry);
            const destination = path.join(buildDir, entry);

            await fs.cp(source, destination, {
                recursive: true,
                dereference: true,
            });
        }),
    );

    console.log(`🗜️ Creating ZIP archive: ${zipName}`);
    execFileSync("zip", ["-r", zipAbsolutePath, "."], {
        cwd: buildDir,
        stdio: "inherit",
        shell: true,
    });

    console.log(`✨ Build complete: ${zipName}`);
}

main().catch((error) => {
    console.error("❌ Build failed:", error);
    process.exit(1);
});
