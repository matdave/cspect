cspect.window.SourceDirective = function (config) {
    config = config || {
        directive: {
            id: 0,
            name: "",
        },
        source: {
            id: 0,
            name: "",
        }
    };

    Ext.apply(config, {
        title: _('cspect.sourcedirective'),
        url: cspect.config.connectorUrl,
        baseParams: this.getParams(config),
        modal: true,
        autoHeight: true,
        closeAction: 'close',
        collapsible: false,
        fields: this.getFields(config),
    });
    cspect.window.SourceDirective.superclass.constructor.call(this, config);
}
Ext.extend(cspect.window.SourceDirective, MODx.Window, {
    getParams: function(config) {
        var params = {
            action: 'CSPect\\Processors\\SourceDirectives\\Create',
        }
        if (config.directive) {
            params.directive = config.directive.id;
        }
        if (config.source) {
            params.source = config.source.id;
        }
        return params;
    },
    getFields: function(config) {
        var fields = [];
        if (config.directive) {
            fields.push({
                xtype: 'cspect-combo-sources',
                fieldLabel: _('cspect.sourcedirective_source'),
                directive: config.directive.id,
                name: 'source_name',
                hiddenName: 'source',
                anchor: '100%',
            });
        }
        if (config.source) {
            fields.push({
                xtype: 'cspect-combo-directives',
                fieldLabel: _('cspect.sourcedirective_directive'),
                source: config.source.id,
                name: 'directive_name',
                hiddenName: 'directive',
                anchor: '100%',
            });
        }
        return fields;
    }
});
Ext.reg('cspect-window-sourcedirective-create', cspect.window.SourceDirective);