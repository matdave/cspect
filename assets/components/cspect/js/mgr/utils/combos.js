cspect.combo.Directives = function (config) {
    config = config || {
        source: 0
    };
    Ext.applyIf(config, {
        fields: config.source ? ['value', 'text'] : ['value'],
        displayField: config.source ? "text" : "value",
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
            action: "CSPect\\Processors\\Combo\\Directives",
            source: config.source || null
        }
    });
    cspect.combo.Directives.superclass.constructor.call(this, config);
};
Ext.extend(cspect.combo.Directives, MODx.combo.ComboBox);
Ext.reg("cspect-combo-directives", cspect.combo.Directives);

cspect.combo.Sources = function (config) {
    config = config || {
        directive: 0
    };
    Ext.applyIf(config, {
        fields: ['value', 'text'],
        displayField: "text",
        valueField: "value",
        mode: "remote",
        triggerAction: "all",
        emptyText: _("cspect.combo.empty.source"),
        editable: true,
        selectOnFocus: false,
        preventRender: true,
        forceSelection: true,
        enableKeyEvents: true,
        url: cspect.config.connectorUrl,
        pageSize: 10,
        baseParams: {
            action: "CSPect\\Processors\\Combo\\Sources",
            directive: config.directive
        }
    });
    cspect.combo.Sources.superclass.constructor.call(this, config);
}
Ext.extend(cspect.combo.Sources, MODx.combo.ComboBox);
Ext.reg("cspect-combo-sources", cspect.combo.Sources);

cspect.combo.Contexts = function (config) {
    config = config || {
        source: 0
    };
    Ext.applyIf(config, {
        fields: ['value', 'text'],
        displayField: "text",
        valueField: "value",
        mode: "remote",
        triggerAction: "all",
        emptyText: _("cspect.combo.empty.context"),
        editable: true,
        selectOnFocus: false,
        preventRender: true,
        forceSelection: true,
        enableKeyEvents: true,
        url: cspect.config.connectorUrl,
        pageSize: 10,
        baseParams: {
            action: "CSPect\\Processors\\Combo\\Contexts",
            source: config.source
        }
    });
    cspect.combo.Contexts.superclass.constructor.call(this, config);
}
Ext.extend(cspect.combo.Contexts, MODx.combo.ComboBox);
Ext.reg("cspect-combo-contexts", cspect.combo.Contexts);