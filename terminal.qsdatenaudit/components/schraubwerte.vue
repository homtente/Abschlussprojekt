<template>
    <div class="schraubwerte">
        <h2>Schraubwerte</h2>
        <!-- Wenn Daten vorhanden bei click wird PopUp Menü geöffnet -->
        <div v-if="currentScrewdatavorhanden" class="datatrue" @click="showscrewdetails = true">
            <screw_svg class="screwsvg"/>
            <h5>Daten vorhanden klicke für Details</h5>
            <!-- popup menü  -->
            <div v-if="showscrewdetails" class="popup">
                <!-- popup header mit Überschrift und Close Button -->
                <div class="popup_header">
                    <h2> Details zu Arbeitsfolgen </h2>
                    <button class="close_button" @click.stop="showscrewdetails = false"><close_svg/></button>
                </div>
                <!-- Card Container baut Card für jede Station -->
                <div class="card_container">
                    <div class="row">
                        <!-- Card für jede Station anlegen mit Click Funktion für Details -->
                        <div v-for="(station, index) in currentScrewdata" :key="index" class="col-sm-4 mb-3">
                            <div class="card" @click="showstationdetails(station, index)">
                                <div class="card_body">
                                    <h5>Station {{ index }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div v-else class="datanotrue">
            <h5>Keine Daten vorhanden</h5>
            <screw_svg class="screwsvg"/>
        </div>

        <!-- POP UP für die Arbeitsfolgendetails wenn auf station geklickt wird -->
        <div v-if="showarbeitsfolge" class="popup">
            <!-- Arbeitsfolgen POPUP Header -->
            <div class="popup_header">
                <h2> Arbeitsfolge für {{ selectedstation }}</h2>
                <button class="close_button" @click="showarbeitsfolge = false"><close_svg/></button>
            </div>
            <!-- Vfor schleife um arbeitsfolgen auszugeben -->
            <div v-for="(arbeitsfolge, index) in selectedstationdata" class="arbeitsfolgen_content">
                <p> {{ index }} {{ arbeitsfolge.Ergebnis_Schraubabgleich ? 'IO' : 'NIO' }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import close_svg from './close_svg.vue';
import screw_svg from './screw_svg.vue';
export default {
    
    name: 'schraubwerte',
    
    components: {
        close_svg,
        screw_svg,
    },

    data() {
        return {
            // Steuervariablen
            data_vorhanden: false,
            showscrewdetails: false,
            showarbeitsfolge: false,

            // String für stationsname und stationsdaten
            selectedstationdata: '',
            selectedstation: '',
        };
    },

    methods:{
        // Funktion um Station von Cardklick zu nutzen um entsprechende Attribute im POPUP zu rendern
        showstationdetails(station, index) {
            this.selectedstationdata = station;
            this.showarbeitsfolge = true;
            this.selectedstation = index;
        },
        // Wenn
        closestationdetails(station) {
            this.selectedstationdata = '';
            this.showarbeitsfolge = false;
            this.selectedstation = '';
        }
    },
    computed:{
        // Hole Screwdata Objekt über Getter im Store
        currentScrewdata() {
            return this.$store.getters['store_datenaudit/get_screwdata']
        },
        // Funktion zum prüfen ob Screwdata nicht leer
        currentScrewdatavorhanden(){
            if (this.currentScrewdata.length === 0) {
                return false
                
            } else {
                return true
                
            }
        }

    },
};
</script>


<style scoped>
.schraubwerte {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}
.datatrue {
    width: 80%;
    height: 80%;
    cursor: pointer;
    border: 5px solid;
    border-color: var(--system-green-500);
}

.datanotrue {
    width: 80%;
    height: 80%;
    cursor: pointer;
    border: 5px solid;
    border-color: var(--system-red-500);
}

.popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80%;
    height: 80%;
    background-color: #f0f1f2;
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 10px;
    z-index: 1000;
}

.card {
    background-color: var(--vivid-green-600);
    color: var(--primary-color-text) ;
    padding:2%;
    width: 100%;
    height: 90px;
    
}

.arbeitsfolgen_content p {
    margin: 0;
    padding: 0;
    font-size: small;
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

.screwsvg {
    margin-top: 15%;
}

</style>