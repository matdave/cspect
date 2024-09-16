var CSPect = function (config) {
    config = config || {};
    CSPect.superclass.constructor.call(this, config);
};
Ext.extend(CSPect, Ext.Component, {

    page: {},
    window: {},
    grid: {},
    tree: {},
    panel: {},
    combo: {},
    field: {},
    config: {},

});
Ext.reg('cspect', CSPect);
cspect = new CSPect();
