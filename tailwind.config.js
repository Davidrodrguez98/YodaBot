module.exports = {
    purge: {
        content: ['./public/**/*.html', './src/**/*.vue'],
        options: {
          whitelistPatterns: [
            /-(leave|enter|appear)(|-(to|from|active))$/,
            /^(?!(|.*?:)cursor-move).+-move$/,
            /^router-link(|-exact)-active$/,
            /tooltip/,
            /popover/,
            /notification/,
          ],
        }
      },
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {}
    },
    variants: {
        extend: {}
    },
    plugins: []
};
