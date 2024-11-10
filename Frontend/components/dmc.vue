<template>
    <div class="dmc_container">
        <!-- Prüfung ob Daten zu DMCs im Store vorhanden sind -->
        <h2 v-if="isArrayempty" class="datafalse"> Keine Daten vorhanden </h2>
        <div v-else>

            <!-- Wenn kein match gefunden ist zeigt er Buttons für Zuordnung und Löschung -->
            <div v-if="notfounddmc">
                <div>
                    <!-- Container für für Buttons um Zuordnungmenü zu löschen oder Eingabe zurückzusetzen  -->
                    <div class="button_container">
                        <button class="dmc_zuordnen" @click="this.showPopup = true">Nicht gefunden! DMC zuordnen</button>
                        <button class="false_input" @click="this.real_dmc =''; this.notfounddmc = false">Falscheingabe</button>
                    </div>
                        <!-- popup wenn Button für Zuordnung gedrückt wurde -->
                        <div v-if="showPopup" class="popup">
                            <div class="popup_header">
                                <h4 class="title_zuordnung"> DMC: {{ real_dmc }} nicht gefunden Ordne es einem System Teil zu</h4>
                                <button class="close_button" @click="this.showPopup = false"><close_svg/></button>
                            </div>
                            <div class="row">
                                <!-- interne framework class col ... -->
                                 <!-- Schleife durch DMC Objekt Erstellung einer Card für jedes Bauteil -->
                                <div v-for="(dmc, index) in currentDMCs" :key="index" class="col-sm-4 mb-3"> 
                                    <!-- Wenn auf Card geklickt wird, Funktion für Zuordnung auslösen -->
                                    <div class="card" @click="zuordnung(index)">
                                        <div class="card-body">
                                            <h5 class="card-title"> {{ dmc.description }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>


<!-- Tabelle für DMCs -->
            <table>
                <!-- Festlegung der Breite der Spalten der Tabelle -->
                <colgroup>
                <col style="width: 10%;">
                <col style="width: 15%;">
                <col style="width: 15%;">
                <col style="width: 2%;">
                </colgroup>
                <!-- Tableheader für die 4 Spalten -->
                <thead>
                    <tr>
                        <th>Bauteil</th>
                        <th>DMC System</th>
                        <th>DMC Real</th>
                        <th>Status</th>
                    </tr>
                </thead>
                
                <tbody>
                    <!-- Schleife um Tablerows für jeden DMC zu erstellen, bereits Platzhalter für die Attribute die über Zuordnung erfolgen -->
                    <!-- css klassen für styling je nach Art des Status -->
                    <tr v-for="(dmc, index) in currentDMCs" :key="index" scope="row" :class="{'status_ok': dmc.status === 'ok', 
                    'status_error': dmc.status === 'error'}">
        
                        <td> {{ dmc.description }}</td>
                        <td> {{ dmc.name  }}</td>
                        <td> {{ dmc.real }} </td>
                        <td> {{ dmc.status }}</td>

                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>    
</template>

<script>
import close_svg from './close_svg.vue';
export default {
    name: 'DMC',

    components: {
        close_svg,
    },
    data() {
        return{
         
            real_dmc: '',
            // Steuervariable, ob real_dmc mit einem system dmc übereinstimmt
            notfounddmc: false,
            showPopup: false,
            matchfound: false,
        }
    },
    
    computed: {
        // Spricht Getter get_dmcs in vuex store an gibt data objekt dmcdata zurück
        currentDMCs() {
            return this.$store.getters['store_datenaudit/get_dmcs'] || [];
        },
        // prüft ob dmc data leer ist
        isArrayempty() {
            console.log(this.currentDMCs)
            return this.currentDMCs.length === 0;
        }
    },

    methods: {
        
        keypressevent(event) {
            if (this.isArrayempty) return; // Kein Observer wenn Array leer ist
            this.matchfound = false;

            // jede eingabe abfangen
            const key = event.key;

            // Wenn die Enter-Taste gedrückt wurde und Eingabe nicht leer ist
            if (key === 'Enter' && this.real_dmc !== '') {
                console.log(this.real_dmc)
                

                // Vergleicht jedes Element des DMC arrays mit dem eingegebenen string
                this.currentDMCs.forEach((dmc, index) => {

                    // Vergleich beachtet keine Leerzeichen aufgrund von Autark Rückgabe
                    if (this.real_dmc === dmc.name.replace(/\s+/g, '') && this.real_dmc !== '') { // TEST NÖTIG OB zweite Bedingung nötig ist eigentlich nicht
                        console.log(`prüfe DMC ${this.real_dmc}`);
                        
                        // Calle Mutation im Store, um DMC Data Objekt zu modifizieren Übergabe eines Objektes mit Index des matchenden DMCs
                        this.$store.dispatch("store_datenaudit/callsetstatusdmc", {
                            index: index, 
                            real_dmc: this.real_dmc,
                            status: 'ok'
                        });
                        // Steuervariable setzen, das Match gefunden wurde und zurücksetzen der Eingabe
                        this.matchfound = true;
                        this.real_dmc = ''; 
                    } 
                }); 

                // Bei keinem Vergleich notfounddmc auf true setze -> Buttons werden sichtbar
                if (!this.matchfound) {
                    this.notfounddmc = true;
                }
                
            } else {
                // Füge Eingabe dem String zu der verglichen wird
                this.real_dmc += key;
            }
        },

        // Method um nicht übereinstimmenden DMC zuordnen
        zuordnung(index){
            // Ruft identische Funktion auf bei Match, Index kommt dann aus Modal Element
            this.$store.dispatch("store_datenaudit/callsetstatusdmc", {
            index: index, 
            real_dmc: this.real_dmc,
            status:  'error'
            })
            // Zurücksetzen der Steuervariablen nach Zuordnung
            this.notfounddmc = false;
            this.showPopup = false;
            this.real_dmc = '';
           
        },
    },
    mounted() {

        // starte keyobserver wenn vue component geladen wird
        window.addEventListener('keypress', this.keypressevent);
        // console.log("EVENT LISTENER GEMOUNTED")
    },
    // Stoppe Keyobserver wenn 
    beforeUnmount() {
        window.removeEventListener('keypress', this.keypressevent)
        // console.log("EVENT LISTENER ENTFERNT")
    }

}
</script>

<style scoped>

    .datafalse {
        text-align: center;
        padding-top: 25%;
        color: var(--system-red-500)

    }
    .dmc_container {
        display: grid;
    }
    .popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%;
        height: 80%;
        background-color: var(--surface-card) ;
    }

    .title_zuordnung {
        text-align: center;
    }

    .popup_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .close_button {
  
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        z-index: 1000;
    }
    
    .card {
        background-color: var(--vivid-green-600);
        color: var(--primary-color-text) ;
        padding:2%;
        width: 100%;
        height: 80px;
    }
    .card-body {
        text-align: center;
    }
    table {
        border: none;
        border-collapse: collapse;
        table-layout: fixed;
    }
    th, td {
        font-size: 14px;
        text-align: left;
        vertical-align: left;
        padding: 0.15rem;
    }
    tr, th {
        border-bottom: 1px solid #ccc;
    }
    tr:last-child {
        border-bottom: none ;
    }

    th, td {
        border-right:1px solid #ccc;
    }

    th:last-child, td:last-child {
            border-right: none; 
        }

    .status_error {
        background-color: var(--system-red-500);
    }
    .status_ok {
        background-color: var(--system-green-500);
    }
    .button_container{
        display: flex;
        justify-content: space-between;
        width: 40%;
    }

   .dmc_zuordnen, .false_input{
        padding: 1%;
        margin: 0.3rem;
        border-radius: 999px; 
        flex: 1; 
        border-color: var(--primary-color);
   }

    :deep() .false_input {
        color: var(--vivid-green-600) !important;
        border: 1px solid var(--vivid-green-600) !important;
        background-color: #ffffff !important;
    }
    :deep() .false_input:hover{
        border-color: var(--vivid-green-600) !important;
        background-color: rgba(0, 128, 117, .10) !important;
        color: var(--vivid-green-600) !important;
    }
    :deep() .false_input:active{
        border-color: var(--vivid-green-600) !important;
        background-color: rgba(0, 128, 117, .20) !important;
        color: var(--vivid-green-600) !important;
    }

    :deep() .dmc_zuordnen {
        background-color: var(--vivid-green-600);
        border: 1px solid #DEE1E3;
        color: #ffffff;
    }
    :deep() .dmc_zuordnen:hover{
        background-color: var(--vivid-green-700);
    }
    :deep() .dmc_zuordnen:active{
        background-color: var(--vivid-green-800);
    }


</style>



