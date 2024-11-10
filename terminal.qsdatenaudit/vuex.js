
export default {

	name: 'store_datenaudit',  // Name des Stores
	state: {  // Variablen die global verfügbar sind 
		example: 1,
		pid: "",
		dmcdata: [],
		screwdata: [],
		interventions: '',
		isloading: false,
	},
	mutations: { 	// hier werden methoden deklariert zum manipulieren / verändern der variablen / state

		// Interventions setzen (vorallemm für Actions)
		setInterventionsdata(state, value){
			state.interventions = value;
		},
		// Schraubwerte setzen (vorallemm für Actions)
		setScrewdata(state, value) {
			state.screwdata = value
		},
		// DMCs setzen (vorallemm für Actions)
		setDMCdata(state, value) {
			state.dmcdata = value
		},

		// Funktion um die PID Variable im State zu setzen
		setPID(state, pid_value) {
			state.pid = pid_value
		},

		// Mutation zum setzen des eingesannten DMCs und dem erkannten status
		setStatusDMC(state, {index, real_dmc, status}) {
			
			state.dmcdata[index].real = real_dmc;
			state.dmcdata[index].status = status;
		
		},
		// loading component triggen
		setloading(state, status_loading) {
			state.isloading = status_loading
			console.log(state.isloading)
		}
	
	},
	actions:{
		// API Function Richtung Backend spricht GET Endpunkte an
		async fetchapis(context){
			// loading component start
			context.commit("setloading", true)
			// Backendendpunkt 1 ansprechen
			this.$http
			.get(`vw_qs_audit/v1/autadesapi_productionoverview?pId=${context.state.pid}`)
			// Wenn response true ist commite Daten an mutation
			.then(response => {
				if(response.data.success == true){	

                    context.commit("setDMCdata", response.data.payload);
				} else {
					console.log(response);
				}
				// errorhandling wenn abfrage error wirft
			}).catch(err => {
				console.error(err);
			})
			// Backendendpunkt 2 ansprechen
			this.$http
			.get(`vw_qs_audit/v1/autadesapi_productionProtocol?serialNumber=${context.state.pid}`)
			// Wenn response true ist commite Daten an mutation
			.then(response => {
				if(response.data.success == true){	
					
                    context.commit("setInterventionsdata", response.data.payload);
				} else {
					console.log(response);
				}
				// errorhandling wenn abfrage error wirft
			}).catch(err => {
				console.error(err);
			})
			// Backendendpunkt 3 ansprechen
			this.$http
			.get(`vw_qs_audit/v1/autadesapi_pidComparison?Pids=${context.state.pid}`)
			// Wenn response true ist commite Daten an mutation
			.then(response => {
				if(response.data.success == true){	
					
                    context.commit("setScrewdata", response.data.payload);
				} else {
					console.log(response);
				}
				// errorhandling wenn abfrage error wirft
			}).catch(err => {
				console.error(err);
			}) .finally(() => {
			context.commit("setloading", false)
			})
		},

		// Action um PID zu updaten called mutation mit der übergebenen new pid
		callmutations_pid(context, new_pid_value) {
			// console.log(new_pid_value);
			context.commit('setPID', new_pid_value);
		},
		// Action um System DMC zu Real DMC zuzuordnen call Mutation zum manipulieren des States 
		callsetstatusdmc(context, {index, real_dmc, status}) {

			context.commit('setStatusDMC', {index, real_dmc, status})
		}
	},


	// Getters bei aufruf geben sie die Datenobjekte aus dem State in die jeweilige Komponente
	getters:{
		
		get_dmcs(state){
			return state.dmcdata;
		},

		get_screwdata(state){
			return state.screwdata
		},

		get_interventions(state){
			return state.interventions
		}
	},
	namespaced: true
};
