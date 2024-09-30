cspect.window.SourceContext = function (config) {
    config = config || {
        source: {
            id: 0,
            name: ""
        },
        context: {
            key: "",
        }
    };
    Ext.applyIf(config, {
        title: _('cspect.sourcecontext'),
        url: cspect.config.connectorUrl,
        baseParams: this.getParams(config),
        modal: true,
        autoHeight: true,
        closeAction: 'close',
        fields: this.getFields(config),
    });
    cspect.window.SourceContext.superclass.constructor.call(this, config);
}

Ext.extend(cspect.window.SourceContext, MODx.Window, {
    getParams: function(config) {
        var params = {
            action: 'CSPect\\Processors\\SourceContexts\\Create',
        }
        if (config.source) {
            params.source = config.source.id;
        }
        if (config.context) {
            params.context_key = config.context.key;
        }
        return params;
    },
    getFields: function(config) {
        var fields = [];
        if (config.source) {
            fields.push({
                xtype: 'cspect-combo-contexts',
                fieldLabel: _('cspect.sourcecontext_context'),
                source: config.source.id,
                name: 'context_key_name',
                hiddenName: 'context_key',
                anchor: '100%',
            });
        }
        if (config.context) {
            fields.push({
                xtype: 'cspect-combo-sources',
                fieldLabel: _('cspect.sourcecontext_source'),
                context: config.context.key,
                name: 'source_name',
                hiddenName: 'source',
                anchor: '100%',
            });
        }
        return fields;
    }
});
Ext.reg('cspect-window-sourcecontext-create', cspect.window.SourceContext);