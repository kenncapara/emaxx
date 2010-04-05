App.globalToolbar = function () {
    return new Ext.Toolbar({
        region : 'north',
        height: 25,
        items  : [
            '->',
            // {
            //     text : 'Change Password',
            //     iconCls : 'change-password',
            //     handler : function () {
            //         // window.location.href = App.profileUrl;
            //     }
            // },
            {
                text : 'Logoff',
                iconCls : 'logoff',
                handler : function () {
                    window.location.href = "/auth/logoff";
                }
            }
        ]
    });
};
