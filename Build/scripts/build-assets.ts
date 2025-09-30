import {build} from 'vite';
import {getBaseConfig} from '../vite.config';
import fs from 'fs/promises';
import path from 'node:path';
import {fileURLToPath} from 'node:url';
import svgstore from 'svgstore';
import {optimize} from 'svgo';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const rootDir = path.resolve(__dirname, '..');
const configPath = path.join(rootDir, 'assets.config.json');
const args = process.argv.slice(2);
const watchMode = args.includes('--watch');


interface ViteAsset {
  dist: string;
  inputs: {
    [name: string]: string;
  };
}

interface SpriteAsset {
  inputDir: string;
  outputFile: string;
}

interface AssetConfig {
  vite: {
    [packageName: string]: ViteAsset;
  };
  sprite?: {
    [name: string]: SpriteAsset;
  };
}

async function main(): Promise<void> {
  const rawConfig = await fs.readFile(configPath, 'utf-8');
  const parsedConfig = JSON.parse(rawConfig) as AssetConfig;

  if (parsedConfig.sprite) {
    for (const [name, spriteConfig] of Object.entries(parsedConfig.sprite)) {
      try {
        await generateSprite(spriteConfig);
      } catch (err) {
        console.error(`Failed to generate sprite "${name}":`, err);
      }
    }
  }

  for (const [packageName, {dist, inputs}] of Object.entries(parsedConfig.vite)) {
    console.log(`Building assets for: ${packageName}`);

    // Resolve all input paths relative to rootDir
    const resolvedInputs: Record<string, string> = {};
    for (const [name, inputPath] of Object.entries(inputs)) {
      resolvedInputs[name] = path.resolve(rootDir, inputPath);
    }

    const resolvedDist = path.resolve(rootDir, dist);
    const viteConfig = getBaseConfig(resolvedInputs, resolvedDist);

    if (watchMode) {
      viteConfig.build = {
        ...viteConfig.build,
        watch: {}
      };
      console.log(`Watching assets for: ${packageName}...`);
    }

    try {
      await build(viteConfig);
      if (!watchMode) {
        console.log(`Built assets for ${packageName} into ${resolvedDist}`);
      }
    } catch (err) {
      console.error(`Build failed for ${packageName}`, err);
    }
  }
}

async function generateSprite(config: SpriteAsset): Promise<void> {
  const inputDir = path.resolve(rootDir, config.inputDir);
  const outputFile = path.resolve(rootDir, config.outputFile);
  const sprite = svgstore({inline: true, svgAttrs: {xmlns: 'http://www.w3.org/2000/svg'}});

  const files = await fs.readdir(inputDir);
  for (const file of files) {
    if (file.endsWith('.svg')) {
      const id = path.basename(file, '.svg');
      const filePath = path.join(inputDir, file);
      const rawSvg = await fs.readFile(filePath, 'utf8');

      // Optional: optimize SVG
      const optimized = optimize(rawSvg, {
        path: filePath,
        multipass: true,
      });

      if ('data' in optimized) {
        sprite.add(id, optimized.data);
      } else {
        console.warn(`Skipping ${file}: SVGO failed`);
      }
    }
  }

  await fs.mkdir(path.dirname(outputFile), {recursive: true});
  await fs.writeFile(outputFile, sprite.toString(), 'utf8');
  console.log(`Generated sprite: ${outputFile}`);
}

main().catch((err) => {
  console.error('Unexpected error during build:', err);
  process.exit(1);
});
