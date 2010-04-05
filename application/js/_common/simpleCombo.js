App.simpleCombo = function (params) {
    
    var defaults = {
        triggerAction: 'all',
        forceSelection: true,
        typeAhead: true,
        hiddenName: params.name
    };
    
    var cmp = new Ext.form.ComboBox(Ext.apply({}, params, defaults));
    
    return cmp;
};