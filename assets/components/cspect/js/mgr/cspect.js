var CspEct = function (config) {
    config = config || {};
    CspEct.superclass.constructor.call(this, config);
};
Ext.extend(CspEct, Ext.Component, {

    page: {},
    window: {},
    grid: {},
    tree: {},
    panel: {},
    combo: {},
    field: {},
    config: {},

});
Ext.reg('cspect', CspEct);
cspect = new CspEct();
