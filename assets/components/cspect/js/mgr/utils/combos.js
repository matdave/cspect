cspect.combo.Directives = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        fields: ['value'],
        displayField: "value",
        valueField: "value",
        mode: "remote",
        triggerAction: "all",
        emptyText: _("cspect.combo.empty.directive"),
        editable: true,
        selectOnFocus: false,
        preventRender: true,
        forceSelection: true,
        enableKeyEvents: true,
        url: cspect.config.connectorUrl,
        pageSize: 10,
        baseParams: {
            action: "CSPect\\Processors\\Combo\\Directives"
        }
    });
    cspect.combo.Directives.superclass.constructor.call(this, config);
};
Ext.extend(cspect.combo.Directives, MODx.combo.ComboBox);
Ext.reg("cspect-combo-directives", cspect.combo.Directives);