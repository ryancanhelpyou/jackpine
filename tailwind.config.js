module.exports = {
    purge: ["./templates/**/*.twig"],
    plugins: [
        require('@tailwindcss/typography')
    ],
    theme: {
        extend: {
            colors: {
                'navy': '#00263e',
                orange: '#b15533',
                blue:   '#004b7a',
                yellow: '#f7a532',
                green:  '#136f63',
                gray: {
                    '800': '#3c3c3d',
                    '400': '#cfc9c5',
                    '100': '#f8f4f1',
                },
            },
            borderWidth: {
                '.5': '0.5px',
            },
          }
    },
};
