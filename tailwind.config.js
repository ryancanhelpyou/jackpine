module.exports = {
    purge: ["./templates/**/*.twig"],
    plugins: [
        // require('@tailwindcss/typography')
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
            spacing: {
                '14': '3.5rem',
            },
        },
        // typography plugin overrides: https://github.com/tailwindlabs/tailwindcss-typography
        typography: (theme) => ({
            default: {
              css: {
                h1: {
                    color: theme('colors.navy'),
                },
              },
            },
        }),
    },
    variants: {
        // add group hover to scale icons: https://tailwindcss.com/docs/pseudo-class-variants#group-hover
        scale: ['responsive', 'hover', 'focus', 'group-hover'],

      },
};
