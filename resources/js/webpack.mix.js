module.exports = {
    scanForCssSelectors: [],
    webpackPlugins: [],
    safelist: [],
    install: [],
    copy: [],
    mix: {
        css: [
            {input: 'app/cortex/tenants/resources/sass/theme-tenantarea.scss', output: 'public/css/theme-tenantarea.css'},
            {input: 'app/cortex/tenants/resources/sass/theme-managerarea.scss', output: 'public/css/theme-managerarea.css'},
        ],
        js: [],
    },
};
