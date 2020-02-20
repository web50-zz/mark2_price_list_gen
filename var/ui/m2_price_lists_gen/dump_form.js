ui.m2_price_lists_gen.dump_form = function(config){
	Ext.apply(this, config);
	this.Load = function(id){
		var f = this.getForm();
		f.load({
		});
		f.setValues([{id: '_sid', value: id}]);
	}
	var Save = function(){
		var f = this.getForm();
		if (f.isValid()){
			f.submit({
				url: 'di/m2_price_lists_gen/set.do',
				waitMsg: this.saveText,
				success: function(form, action){
					var d = Ext.util.JSON.decode(action.response.responseText)
					if (d.success)
						this.fireEvent('saved', d.data);
					else
						showError(d.errors);
				},
				failure: function(form, action){
					switch (action.failureType){
						case Ext.form.Action.CLIENT_INVALID:
							showError(this.errInputText);
						break;
						case Ext.form.Action.CONNECT_FAILURE:
							showError(this.errConnectionText);
						break;
						case Ext.form.Action.SERVER_INVALID:
							showError(action.result.errors);
					}
				},
				scope: this
			});
		}
	}.createDelegate(this);
	var Cancel = function(){
		this.fireEvent('cancelled');
	}.createDelegate(this);
	ui.m2_price_lists_gen.dump_form.superclass.constructor.call(this, {
		frame: true, 
		labelWidth:200, 
		defaults: {xtype: 'textfield', width: 250},
		items: [
			{fieldLabel: this.labelInst, hiddenName: 'inst_id', xtype: 'combo', emptyText: this.blankTypeText, valueNotFoundText: this.blankTypeText,
				store: new Ext.data.JsonStore({url: 'di/m2_price_lists_gen/price_list_types.json', root: 'records', fields: ['id', 'title'], autoLoad: true}),
					valueField: 'id', 
					displayField: 'title', 
					mode: 'local', 
					triggerAction: 'all', editable: false
			}
		],
		buttonAlign: 'right',
		buttons: [
			{iconCls: 'disk', text: this.bttSave, handler: Save},
			{iconCls: 'cancel', text: this.bttCancel, handler: Cancel}
		]
	});
	this.addEvents(
		"saved",
		"cancelled"
	);
	this.on({
		saved: function(data){
			Ext.Msg.alert(this.subMsgBox,data.msg);
		},
		scope: this
	})
}
Ext.extend(ui.m2_price_lists_gen.dump_form , Ext.form.FormPanel, {
	labelType:'Как',
	labelInst:'Что экспортировать',
	labelOps:'Сделать',
	labelDop:'Дополнительно',
	loadText: 'Загрузка данных формы',
	subMsgBox: ' ',
	saveText: 'Сохранение...',

	bttSave: 'Выполнить',
	bttCancel: 'Отмена',

	errSaveText: 'Ошибка во время сохранения',
	errInputText: 'Корректно заполните все необходимые поля',
	errConnectionText: "Ошибка связи с сервером"
});
