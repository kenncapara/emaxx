App.center = function() {
    return new Ext.TabPanel({
        id        : 'main-tabpanel',
        region    : 'center',
        activeTab : 0,
        defaults  : {
            closable : true
        },
        deferredRender: false,
        layoutOnTabChange:true,
        items : [
            {
                title : 'Home',
                closable : false
            }
        ]
    });
};
