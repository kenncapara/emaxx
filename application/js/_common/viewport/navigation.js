App.navigation = function() {
    
    function processNode(node) {
        if (node.attributes.loadTab) {
            App.loadTab(node.attributes.loadTab);
        }
        if (node.attributes.callFunc) {
            eval('App.' + node.attributes.callFunc + '()');
        }
    }
    
    var tree = new Ext.tree.TreePanel({
        autoScroll  : true,
        border: false,
        loader      : new Ext.tree.TreeLoader({
           dataUrl      : '/main/nav/',
           listeners    : {
               'load'   : function(t, n, r) {
                   n.expandChildNodes();
               }
           }
        }),
        root : new Ext.tree.AsyncTreeNode({
           text     : 'Menu',
           expanded : true
        }),
        rootVisible: false,
        
        listeners : {
            'click' : function(node, e) {
                if (node.attributes.loadModule) {
                    if (Ext.isDefined(eval('App.' + node.attributes.loadModule))) {
                        processNode(node);
                    } else {
                        Ext.Ajax.request({
                            url: '/index/module/load/' + node.attributes.loadModule,
                            success: function (r) {
                                eval(r.responseText);
                                processNode(node);
                            }
                        });
                    }
                } else {
                    processNode(node);
                }
            }
        }
    });
    
    
    var cmp = new Ext.Panel({
        layout      : 'fit',
        items       : [ tree ],
        region      : 'west',
        width       : 200,
        split       : true,
        title       : 'Navigation',
        id : 'app-navigation',
        collapsible : true
    });
    
    return cmp;
};