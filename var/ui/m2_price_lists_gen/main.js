ui.m2_price_lists_gen.main = function(config){
	Ext.apply(this, config);
	var dump_form =  new ui.m2_price_lists_gen.dump_form({region: 'center',width:'200'});
	ui.m2_price_lists_gen.main.superclass.constructor.call(this, {
		layout: 'border',
		items: [dump_form]
	});
	this.on({
		scope: this
	});
};
Ext.extend(ui.m2_price_lists_gen.main, Ext.Panel, {
});
