<template>
    <div class="input_pid">
        <input v-model="input_pid_value" class="input_box" placeholder="Scanne eine PID um zu beginnen!"> 
        <div class="button_container">
            <button class="submit_button" @click="submitapicall">PID Abfragen</button>
            <button class="cancel_button" @click="cancel_button">Abbruch</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PID_Abfrage',
    props:[],

    data() {
        return {  
            input_pid_value: '', // variable mit bind oben im input
        
        };
    },

    methods:{


        // wird ausgeführt bei click event von button 'PID Abfragen'
        submitapicall(){

            // aufrufen der update funktion um input in state zu aktualisieren
            this.updatePID()
            console.log(this.input_pid_value)

            
            this.$store.dispatch("store_datenaudit/fetchapis").then(() => {
            document.querySelectorAll('button').forEach(button => button.blur())
			console.log("API CALL")
            // console.log(this.$store.state.dmc)
		    }) 
        },
        // ruft action im store auf
        updatePID() {
                this.$store.dispatch('store_datenaudit/callmutations_pid', this.input_pid_value);
        },
        // zurücksetzen aller Daten
        cancel_button() {
            this.$store.dispatch('store_datenaudit/callmutations_pid', '');
            this.$store.commit('store_datenaudit/setInterventionsdata', '');
            this.$store.commit('store_datenaudit/setScrewdata', []);
            this.$store.commit('store_datenaudit/setDMCdata', []);
         }
    },
};
</script>


<style scoped>
    .input_box{
        color: var(--text-color);
        width: 50%;
        border-radius: 4px;
        transition: border 0.3s ease, border-color 0.6s ease;
        border: 1px solid;
        margin: 0.5rem;
        padding: 0.5rem;
        text-align: center;
    }
    .input_pid{
        display: flex !important;
        flex-direction: column;
        align-items: center;
        justify-content: center !important;
    }
    .input_box:focus{
        border-color: var(--primary-color) !important;
        border-radius: 4px !important;
        border: 4px solid;
        outline:none;
    }

    .button_container{
        display: flex;
        justify-content: space-between;
        width: 40%;
    }

   .cancel_button, .submit_button{
        padding: 2%;
        margin: 0.3rem;
        /* wo ist variable von button */
        border-radius: 999px; 
        flex: 1; 
        border-color: var(--primary-color);
   }
    :deep() .cancel_button {
        color: var(--vivid-green-600) !important;
        border: 1px solid var(--vivid-green-600) !important;
        background-color: #ffffff !important;
    }
    :deep() .cancel_button:hover{
        border-color: var(--vivid-green-600) !important;
        background-color: rgba(0, 128, 117, .10) !important;
        color: var(--vivid-green-600) !important;
    }
    :deep() .cancel_button:active{
        border-color: var(--vivid-green-600) !important;
        background-color: rgba(0, 128, 117, .20) !important;
        color: var(--vivid-green-600) !important;
    }

    :deep() .submit_button {
        background-color: var(--vivid-green-600);
        border: 1px solid #DEE1E3;
        color: #ffffff;
    }
    :deep() .submit_button:hover{
        background-color: var(--vivid-green-700);
    }
    :deep() .submit_button:active{
        background-color: var(--vivid-green-800);
    }


</style>