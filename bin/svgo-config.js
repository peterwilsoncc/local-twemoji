module.exports = {
  multipass: true,
  plugins: [
    {
      name: 'preset-default',
      params: {
        overrides: {
          convertColors: {
          	shortname: false,
          },
          inlineStyles: {
            onlyMatchedOnce: false,
          },
          removeDesc: {
            removeAny: true,
          },
          removeUselessStrokeAndFill : {
          	removeNone: true,
          },
        },
      },
    },
    'convertStyleToAttrs',
    'sortAttrs',
    'removeDimensions',
    'removeRasterImages',
    'removeScripts',
    'removeStyleElement',
    {
      name: 'removeAttrs',
      params: {
        attrs: 'svg:fill:none|svg:xml:space',
      },
    },
  ],
};
