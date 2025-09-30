import {defineConfig} from "vite";
import tailwindcss from "@tailwindcss/vite";

// Function to generate a config with specific inputs and output directory
export function getBaseConfig(input?: Record<string, string>, dist?: string) {
  const baseConfig = {
    base: './',
    plugins: [
      tailwindcss(),
    ],
    build: {
      emptyOutDir: true,
      target: 'es2022',
      minify: 'esbuild' as 'esbuild',
      sourcemap: true,
    }
  };

  // If input and dist are provided, add rollupOptions
  if (input && dist) {
    return defineConfig({
      ...baseConfig,
      build: {
        ...baseConfig.build,
        rollupOptions: {
          input: input,
          output: {
            dir: dist,
            entryFileNames: 'JavaScript/[name].js',
            assetFileNames: (assetInfo) => {
              const fileName = assetInfo.names && assetInfo.names.length > 0 ? assetInfo.names[0] : '';
              const ext = fileName.split('.').pop() || '';

              switch (ext) {
                case 'css':
                  return 'Css/[name].[ext]';
                case 'js':
                  return 'JavaScript/[name].[ext]';
                case 'woff':
                case 'woff2':
                case 'eot':
                case 'ttf':
                  return 'Fonts/[name].[ext]';
                case 'svg':
                  return 'Icons/[name].[ext]';
                case 'png':
                case 'jpg':
                case 'jpeg':
                  return 'Images/[name].[ext]';
                default:
                  return 'General/[name].[ext]';
              }
            },
          },
        },
      },
    });
  }

  // Return the base config if no input/dist provided
  return defineConfig(baseConfig);
}

// Default export for Vite to use when this file is loaded directly
export default getBaseConfig();
