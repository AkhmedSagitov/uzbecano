import globals from 'globals';
import pluginJs from '@eslint/js';
import tseslint from 'typescript-eslint';
import stylisticTs from '@stylistic/eslint-plugin';
import parserTs from '@typescript-eslint/parser';

export default [
  {
    files: [
      'assets/**/*.{js,mjs,cjs,ts,mts,cts}',
    ],
    plugins: {
      '@stylistic/ts': stylisticTs
    },
    rules: {
      '@stylistic/ts/indent': ['error', 2],
      '@stylistic/ts/quotes': ['error', 'single'],
      '@stylistic/ts/semi': ['error', 'always'],
    },
    languageOptions: {
      globals: globals.browser,
      ecmaVersion: 2022,
      parser: parserTs,
    }
  },
  {
    ignores: [
      'node_modules',
      '*.config.{js,mjs,cjs,ts,mts,cts}',
    ],
  },
  pluginJs.configs.recommended,
  ...tseslint.configs.recommended,
];
