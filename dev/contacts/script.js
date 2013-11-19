(function() {
	Model.create({
		page: 'groups',
		pages: ['groups', 'contacts', 'group', 'contact'],
		//what are we seeing atm?
		group: null,
		contact: null
	});
	var model = Model.data;
	var Contacts = (function() {
		var Public = {}, Private = {};
		Public.init = function(){
			//get contacts, check stuff
		};
		Public.showAllGroups = function() {

		};
		Public.showAllContacts = function(){

		};
		Public.showGroup = function(id) {

		};
		Public.showContact = function(id) {

		};
		Public.deleteMainContacts = function(){

		};
		Public.deleteGroupContacts = function(){

		};
		Public.recieveContacts = function(){

		};
		Public.saveGroup = function(){

		};
		Public.saveContact = function(){

		};
		Public.newGroup = function(){

		};
		Public.searchGroups = function(){

		};
		Public.searchContacts = function(){
			
		};
		return Public;
	})();
	View.create(function(name, value) {
		if (name === 'group' || name === 'contact') {
			Router.goTo(model.pages[model.pages.indexOf(name)] + '/' + value);
		}
		if(name === 'page') Router.goTo(value);
	});
	Controller.create(function() {
		$(function() {
			$(document).on('click', '.name', function() {
				Model.modify('group', $(this).attr('id'));
			});
			$(document).on('click', '.member', function() {
				Model.modify('contact', $(this).attr('id'));
			});
			$(document).on('click', '#all', function() {
				Model.modify('page', 'groups');
			});
		});
	});
	Router.create(function(url, count) {
		if (!Router.hash('visible')) Router.goTo(model.page);
		url = url.split('/');
		switch (url[0]) {
			case 'groups':
				Contacts.showAllGroups();
				break;
			case 'contacts':
				Contacts.showAllContacts();
				break;
			case 'group':
				Contacts.showGroup(url[1]);
				break;
			case 'contact':
				Contacts.showContact(url[1]);
				break;
		}
	});
	Contacts.init();
	Router.run();
})();