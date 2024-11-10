import vueXMethods from "./vuex.js";

export const service = {
    
    start: function(router, route) {  // start methode wird aoutomatisch von Vue aufgerufen
    
        /* SET DEFAULTS */
        this.$router = router;
        this.$route  = route;
		this.$store  = router.app.config.globalProperties.$store; // init für store
		// this.$http      = router.app.config.globalProperties.$http; // init für API, müssen gebindet werden, weil async
		// this.$websocket = router.app.config.globalProperties.$websocket; // init für websocket, müssen gebindet werden, weil async

        /* INIT VUEX STORE */
        this.initVuex();

        /* SETUP FOR APP*/
        this.setup();
        
		/* START APP METHODS */
		// this.subscribeChannel();
		
    },

    setup: function(){

		/* ADD ROUTE TO ROUTES OR OTHER SETUP METHODS */
		const myRoute = {
			to: 'qsdatenaudit',                        // muss der app name sein
			path: '/qsdatenaudit', 						// pfad, am besten der app name
			props: true,
			position: this.$route.position,
			component: () => import ('./qsdatenaudit.vue'),     // komponente zuweisen
			meta: { name: "qsdatenaudit", visible: true, icon: 'fa-solid fa-tags', requireAuth: false}, //  Ob die app angezeigt werden soll, icon definieren, Auth einstellung
			messageLabel: {message: '', alwaysShow: false}
		}

		this.$router.addRoute(myRoute);
        
	},

	// #############################################################################################################
	// http beispiel
	// loadConfig: function(){
	// 	var idvw_terminals = this.store.state.terminal.idvw_terminals;

	// 	var param = [];
	// 	param.push('id='+ idvw_terminals);

	// 	this.http
	// 	.get('vw_terminal/v1/module/terminal.stoerungen/configuration/get?'+ param.join('&'))
	// 	.then(response => {

	// 		if(response.data.success == true){	

	// 			this.store.state.comptest.configuration = response.data;

	// 			console.log(response.data);

	// 		}

	// 	})

	// }
	// #############################################################################################################
	// websocket beispiel
	// subscribeChannel: function(){

	// 	this.websocket.subscribe("Script-Kids", this.onMessage.bind(this));	 // Abonnieren eines Websockets, muss an eine Methode gebunden werden, zusätzlich funktion .bind(this) weil async.

	// },

	// onMessage: function(payload){

	// 	this.store.state.template.message.unshift(payload.payload);               // methode des abonnierten Websockets, welche bei Nachrichten ausgeführt wird. Speichert die Werte im store

	// },


	// subscribe: function(){

	// 	this.app.$websocket.subscribe("server/monitoring/vwagkss00007", 
	// 		function(message){ this.onMessage(message); }.bind(this) 
	// 	);

	// 	this.app.$websocket.subscribe("server/monitoring/vwagksspkw39", 
	// 		function(message){ this.onMessage2(message); }.bind(this) 
	// 	);

	// 	this.app.$websocket.subscribe("server/monitoring/vwagksspkw41", 
	// 		function(message){ this.onMessage3(message); }.bind(this) 
	// 	);


	// },

	// onMessage: function(message){																

	// 	this.store.commit("vw_dashboard/setServer1", message.payload.payload);					// Aufruf der mutations vom store (vuex.js)

	// },

	// onMessage2: function(message){

	// 	this.store.commit("vw_dashboard/setServer2", message.payload.payload);

	// },

	// onMessage3: function(message){

	// 	this.store.commit("vw_dashboard/setServer3", message.payload.payload);

	// },
	// #######################################################################################################################

    initVuex: function(){  // registrierung des vuex stores
		
		this.$store.registerModule(vueXMethods.name, vueXMethods);

	}
    
}