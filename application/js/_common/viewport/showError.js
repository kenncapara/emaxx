App.showError = function(resp) {
    
    var resp = Ext.util.JSON.decode(resp.responseText);
    
    
    var messagetpl = new Ext.XTemplate(
        '<h2>{msg}</h2>',
        '<br />',
        '<p>{line} : {file}</p>'
        
    );
    
    var message = new Ext.Panel({
        title       : 'Error',
        html        : messagetpl.applyTemplate(resp),
        bodyStyle   : 'padding: 10px'
    });
    
    var tracetpl = new Ext.XTemplate(
        '<tpl for=".">',
            '<div class="error">',
                '<p>Class: {class}</p>',
                '<p>Function: {function}</p>',
                '<p>Line: {line}</p>',
            '</div>',
        '</tpl>'
    );
    
    var trace = new Ext.Panel({
        title   : 'Trace',
        html    :  tracetpl.applyTemplate(resp.trace),
        bodyStyle   : 'padding: 10px',
        autoScroll : true
    });
    
    var win = new Ext.Window({
        height  : 200,
        width   : 400,
        layout  : 'fit',
        title   : 'Sorry, an error has occurred',
        iconCls : 'app-win-error',
        items   : [
            {
                xtype       : 'tabpanel',
                activeTab   : 0,
                items       : [ message, trace ]
            }
        ]
    });
    
    win.show();
};
