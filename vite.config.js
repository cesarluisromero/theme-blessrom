import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin'
import { wordpressPlugin, wordpressThemeJson } from '@roots/vite-plugin';

export default defineConfig({
  base: '/wp-content/themes/blessrom-theme/public/build/',
  plugins: [
    tailwindcss(),
    laravel({
      input: [
        'resources/styles/app.css',
        'resources/scripts/app.js',
        'resources/styles/editor.css',
        'resources/scripts/editor.js',
      ],
      refresh: true,
    }),

    wordpressPlugin(),

    // Generate the theme.json file in the public/build/assets directory
    // based on the Tailwind config and the theme.json file from base theme folder
    wordpressThemeJson({
      disableTailwindColors: false,
      disableTailwindFonts: false,
      disableTailwindFontSizes: false,
    }),
  ],
  resolve: {
    alias: {
      '@scripts': '/resources/scripts',
      '@styles': '/resources/styles',
      '@fonts': '/resources/fonts',
      '@images': '/resources/images',
    },
  },
})
