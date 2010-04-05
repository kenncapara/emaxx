App.login.loginWindow = function () {
    
    
    var cmp = new Ext.Window({
        title: 'Emaxx Website Manager',
        width: 300,
        height: 130,
        items: [ App.login.form() ],
        layout: 'fit',
        closable: false,
        draggable: false
    });
    
    return cmp;
    
};