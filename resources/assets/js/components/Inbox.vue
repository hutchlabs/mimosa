var _moment = require('moment');

//TODO: finish up methods
Vue.component('gradlead-inbox-screen', {
    
    props: ['authUser', 'usertype', 'permissions'],

    mounted: function () {
        this.setupListeners();
        this.currentMsg = this.defaultMsg;
        this.setList(this.authUser);
        this.setMessages('o');
    },

    data: function () {
        return {
            baseUrl: '/',
            modname: 'Inbox',
            
            inbox: [],
            trash: [],
            sent: [],
            availableMsgs: [],

            filter: '',
            bins: [ { name: 'Sent' }, { name: 'Trash' }, ],
            listView: true,
            messageView: false,
            composeView: false,
            reply: false,

            defaultMsg: { 'id': 'default', 'title': 'none', from:{type:'gradlead'}},
            currentMsg: { 'id': 0, from:{type:'gradlead'}},
        };
    },

    watch: {
        'filter': function (name) { 
            this.setMessages(name);
        },
    },

    events: { },

    computed: {
        everythingLoaded: function () { return this.authUser != null; },
        hasMsgs: function () { return this.availableMsgs.length > 0; },
    },

    methods: {
        setMessages: function(name) {
            if (name=='Sent') { this.availableMsgs =  this.sent; }
            else if (name=='Trash') { this.availableMsgs =  this.trash; }
            else { this.availableMsgs = this.inbox; };
            this.showList();
        },

        setList: function(user) {
            this.inbox = [];
            this.trash = [];
            this.sent = [];
            var self = this;
            if (user.inbox.length>0) {
                $.each(user.inbox, function(i, x) {
                    if (self.isTrash(x)) { self.trash.push(x); }
                    else if (self.isInbox(x)) { self.inbox.push(x); }
                });
            }
            if (user.outbox.length>0) {
                $.each(user.outbox, function(i, x) {
                    if (self.isTrash(x)) { self.trash.push(x); }
                    else if (self.isSent(x)) { self.sent.push(x); }
                });
            }
            this.selectBin({'name':this.filter});
        },

        selectBin: function (bin) { this.filter = bin.name; },

        filterInbox: function(f) {
            var x = [];
            var self = this;
            if (f=='unread') { x =  _.filter(this.inbox, function (m) { return self.isNew(m); }); }
            else if (f=='read') { x =  _.filter(this.inbox, function (m) { return self.isSeen(m); }); }
            else { x = this.inbox };
            this.availableMsgs = x;
        },

        showView: function(v) { 
            if (v=='list') {
                this.listView = true; this.composeView = false; this.messageView = false; 
            }

            if (v=='message') {
                this.listView = false; this.composeView = false; this.messageView = true; 
            }

            if (v=='compose') {
                this.listView = false; this.composeView = true; this.messageView = false; 
            }
        },

        showList: function() { this.showView('list'); },
        showMessage: function() { this.showView('message'); },
        showCompose: function() { this.showView('compose'); },

        compose: function() { 
            this.showCompose();
        },

        selectMsg: function (msg) { this.currentMsg = msg; this.showMessage(); },

        binCount: function (bin) {
            var self = this;
            if (bin=='Sent') { return this.sent.length; }
            if (bin=='Trash') { return this.trash.length; }
            return this.inbox.length;
        },

        binCountClass: function (bin) {
            return (this.binCount(bin) == 0) ? 'badge bg-default pull-right' : 'badge bg-info pull-right';
        },

        labelClass: function(msg) { return (this.isNew(msg)) ? 'b-l-info' : 'b-l-default'; },

        getUrl: function(msg) { return '/o/'+msg.from.organization_id; },

        getImage: function(msg) {
            return (msg.from.type=='student' || msg.from.type=='graduate') ? msg.from.avatar : msg.from.orgurl;
        },

        isSeen: function (msg) { return msg.seen > 0; },
        isNew: function (msg) { return msg.seen == 0; },
        isInbox: function (msg) { return (this.isNew(msg) || this.isSeen(msg)); },
        isTrash: function (msg) { return msg.seen == 2; },
        isSent: function (msg) { return msg.from_id == this.authUser.id; },

        // Ajax calls
        sendMsg: function(msg) {
            this.showList();
        },

        trashMsg: function(msg) {
            msg.seen = 2;
            this.showList(); 
        },
        
        removeMsg: function (msg) {
            var self = this;
            this.$http.delete(self.baseUrl + 'users/inbox/' + msg.id)
                .then(function () {
                    self.inbox = self.removeFromList(this.inbox, msg);
                }, function (resp) {});
        },

        setupListeners: function () {
            var self = this;
            bus.$on('authUserSet', function (user) { self.setList(user); });
            bus.$emit('screenLoaded',self.modname);
        },


        // Helpers
        removeFromList: function (list, item) {
            return _.reject(list, function (i) { return i.id === item.id; });
        },

        isInArray: function (item, array) { return !!~$.inArray(item, array); },

        limitTo: function(v,len) { 
            return v.replace(/<br\/?>/g,' ').substr(0,len); 
        },

        ucwords: function (str) {
            return str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                return letter.toUpperCase();
            });
        },
    },

    filters: { 
        fromNow: function(v) { return _moment(v).fromNow() },
    },
});
