<?php include 'header.php'; ?>

<script src="https://kendo.cdn.telerik.com/2017.2.504/js/kendo.ui.core.min.js"></script>
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2017.2.504/styles/kendo.common.min.css">
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2017.2.504/styles/kendo.bootstrap.min.css">


<div class="container">
    <div class="page-header">
        <h1>Kendo UI</h1>
    </div>
    <p><a href="http://www.telerik.com/kendo-ui">Kendo UI</a> is a component library that uses javascript and jQuery to create data bound components and UI controls.  </p>

    <p>Here I'm using the <a href="http://docs.telerik.com/kendo-ui/framework/mvvm/overview">MVVM</a> component of Kendo to build a simple incremental/clicker style game, which works like a Single Page App. </p>

    <blockquote class="blockquote">
        <p class="mb-0">Model View ViewModel (MVVM) is a design pattern which helps developers separate the Model, which is the data, from the View, which is the user interface (UI). The View-Model part of the MVVM is responsible for exposing the data objects from the Model in such a way that those objects are easily consumed in the View.</p>
        <footer class="blockquote-footer"> <cite title="Telerik">Telerik</cite></footer>
    </blockquote>

    <p>The MVVM framework allows developers to declaratively bind elements on a page to a client-side data model that exists as javascript/JSON, similar to other frameworks such as React and Vue.js.</p>
</div>

<div class="container">
    <h3>Incremental/Clicker game using Kendo MVVM</h3>
   
    <div class="row">
        <div class="col-lg-7">

            <h4>Game UI</h4>
            <p>To start the game, begin by building robots using the build buttons under the unit descriptions. The robots will gather resources which can be used to build fighting units, but building them requires parts. Parts are made via assembly units. Assembly units require territory, so you'll have to create fighters to conquer more land. </p>

            <p>The game itself is an incomplete tech demo.</p>

            <div class="well game">

                <div data-role="tabstrip" style="min-height: 400px;" data-bind="events: {activate: tabSelect}">
                    <ul>
                        <li class="k-state-active">
                            Resources
                        </li>
                        <li>
                            Energy
                        </li>
                        <li>
                            Territory
                        </li>
                    </ul>
            
                    <div data-template="tab-template" data-bind="source: bots" style="min-height: 400px;"></div>
                    
                    <div data-template="tab-template" data-bind="source: energySources" style="min-height: 400px;"></div>
                            
                    <div data-template="tab-template" data-bind="source: fighters" style="min-height: 400px;"></div>
            
              
                </div>

                <label>Energy:</label>
                <span data-bind="text: energy" data-format="n2"></span>

                
                <label>Parts:</label>
                <span data-bind="text: parts" data-format="n2"></span>

                
                <label>Territory:</label>
                <span data-bind="text: territory" data-format="n2"></span>

            </div>

            <h4 class="m-t">Game UI Templating</h4>

            <p>The game UI above is generated using <a href="http://docs.telerik.com/kendo-ui/framework/templates/overview"> Kendo UI Templates</a>. The UI itself consists of empty elements which are data-bound to the MVVM game unit data. The elements are formatted using a template which creates controls and display information for each unit.</p>

            <p>Each tab is bound to a unit type using the following template:</p>
            <pre class="prettyprint">
&lt;script id="tab-template" type="text/x-kendo-template">
    &lt;div class=&quot;row&quot;&gt;
        &lt;div class=&quot;col-md-6&quot;&gt;
            &lt;table class=&quot;w-full&quot;&gt;
                &lt;thead&gt;
                    &lt;tr&gt;
                        &lt;th&gt;Unit Name&lt;/th&gt;                    
                        &lt;th&gt;Owned&lt;/th&gt;   
                    &lt;/tr&gt;
                &lt;/thead&gt;
                &lt;tbody data-template=&quot;unit-template&quot; data-bind=&quot;source: unitData&quot;&gt;&lt;/tbody&gt;
                &lt;tfoot&gt;&lt;/tfoot&gt;
            &lt;/table&gt;
        &lt;/div&gt;
        &lt;div class=&quot;col-md-6&quot; data-template=&quot;unit-info-template&quot; data-bind=&quot;source: unitData&quot;&gt;&lt;/div&gt;  
    &lt;/div&gt;
&lt;/script>
            </pre>

            <p>The template creates a table, and the table is bound to the unit data. Each unit has its own row template as seen below:</p>

            <pre class="prettyprint">
&lt;script id=&quot;unit-template&quot; type=&quot;text/x-kendo-template&quot;&gt;
    &lt;tr data-bind=&quot;click: unitSelect, visible: showUnit&quot; style=&quot;height: 30px !important;&quot;&gt;
        &lt;td data-bind=&quot;text: name&quot;&gt;&lt;/td&gt;
        &lt;td data-bind=&quot;text: owned&quot;&gt;&lt;/td&gt;     
    &lt;/tr&gt;
&lt;/script&gt;
            </pre>

            <p>The two table rwo cells are easily spotted with the declarative bindings to the name and owned properties of the bound unit.</p>

            <p>The row itself also has bindings for visibility (hiding units that are not available), and a click handler. Clicking on a row will update the unit info portion of the tab, which is bound using the following template:</p>

            <pre class="prettyprint">
&lt;script id=&quot;unit-info-template&quot; type=&quot;text/x-kendo-template&quot;&gt;
    &lt;div data-bind=&quot;visible: unitSelected&quot;&gt;
        &lt;h4 data-bind=&quot;text: name&quot;&gt;&lt;/h4&gt; 
        &lt;p data-bind=&quot;text: description&quot;&gt;&lt;/p&gt;
        &lt;p&gt;&lt;span data-bind=&quot;text: name&quot;&gt;&lt;/span&gt;s generate &lt;span data-bind=&quot;text: output.energy&quot;&gt;&lt;/span&gt; energy, #=data.output.parts# parts, and #=data.output.territory# territory per second.&lt;/p&gt;
        &lt;p&gt;Building one unit costs &lt;b&gt;#=data.cost.energy#&lt;/b&gt; energy, &lt;b&gt;#=data.cost.parts#&lt;/b&gt; parts, and &lt;b&gt;#=data.cost.territory#&lt;/b&gt; territory, and require the recycling of &lt;b&gt;#= data.cost.sacrifice #&lt;/b&gt; of your next lower level of units. &lt;/p&gt;
        &lt;p&gt;You have enough resources to make &lt;b data-bind=&quot;text: maxBuild&quot;&gt;&lt;/b&gt; #=data.name#s.&lt;/p&gt;

        &lt;button data-role=&quot;button&quot;
                data-icon=&quot;plus&quot;
                data-bind=&quot;click: buyUnit, enabled: available&quot;&gt;Build&lt;/button&gt;  
        
        &lt;button data-role=&quot;button&quot;
                data-icon=&quot;plus&quot;
                data-bind=&quot;click: buyMaxUnit, enabled: available&quot;&gt;Build &lt;span data-bind=&quot;text: maxBuild&quot;&gt;&lt;/span&gt;&lt;/button&gt;  
    &lt;/div&gt;
&lt;/script&gt;
            </pre>

        </div>




        <div class="col-lg-5">
            <h4>Game Data Model Demo</h4>

            <p>Below is a representation of part of the MVVM data model. It updates in real-time with the rest of the game UI. View the page source in your browser to see the complete game code, as everything runs client-side. </<p>

          <pre class="prettyprint game">
var gameState = kendo.observable({

    energy: <strong class="nocode" data-bind="text: energy"></strong>,

    parts: <strong class="nocode" data-bind="text: parts"></strong>,

    territory: <strong class="nocode" data-bind="text: territory"></strong>,

    selectedUnit: <strong class="nocode" data-bind="text: selectedUnit"></strong>,

    bots: {
        name: "bots", 
        title: "Units",
        unitData: [
            {...},
            {
                name: "Drone bot", 
                description: "Drone bots seek out scrap metal which can be used to make parts for the fighter bots.",
                cost: {
                    energy: 1,
                    parts: 1,
                    territory: 0,
                    sacrifice: 0
                },
                output: {
                    energy: 0,
                    parts: 1,
                    territory: 0,
                    nextUnit: 0
                },
                owned: <strong class="nocode" data-bind="text: bots.unitData[3].owned"></strong>,
            },
        ],
    },

    energySources: {
        name: "energySources", 
        title: "Energy",
        unitData: [
            {...},
            {
                name: "Battery, off-brand", 
                cost: {
                    energy: 0,
                    parts: 1,
                    territory: 1,
                    sacrifice: 0
                },
                output: {
                    energy: 1,
                    parts: 0,
                    territory: 0
                },
                available: this.available,
                owned: <strong class="nocode" data-bind="text: energySources.unitData[3].owned"></strong>,
            },
        ],
    }, 

    fighters: {
        name: "fighters",
        title: "Territory",
        unitData:  [
            {...},
            {
                name: "Knife Equipped Roomba", 
                cost: {
                    energy: 1,
                    parts: 1,
                    territory: 0,
                    sacrifice: 0
                },
                output: {
                    energy: 0,
                    parts: 0,
                    territory: 1
                },
                available: this.available,
                owned: <strong class="nocode" data-bind="text: fighters.unitData[3].owned"></strong>,
            },
        ],
    },

});
          </pre>
        </div>
    </div>
</div>

<script id="tab-template" type="text/x-kendo-template">
    <div class="row">
        <div class="col-md-6">
             <table class="w-full">
                <thead>
                    <tr>
                        <th>Unit Name</th>                    
                        <th>Owned</th>   
                        <!--<th>buy</th>-->
                    </tr>
                </thead>
                <tbody data-template="unit-template" data-bind="source: unitData"></tbody>
                <tfoot></tfoot>
            </table>
        </div>

        <div class="col-md-6" data-template="unit-info-template" data-bind="source: unitData"></div>   
 
    </div>
</script>


<script id="unit-template" type="text/x-kendo-template">
    <tr data-bind="click: unitSelect, visible: showUnit" style="height: 30px !important;">
        <td data-bind="text: name"></td>
        <td data-bind="text: owned"></td>     
    </tr>
</script>

<script id="unit-info-template" type="text/x-kendo-template">

    <div data-bind="visible: unitSelected">
        
        <h4 data-bind="text: name"></h4> 
        <p data-bind="text: description"></p>
        <p><span data-bind="text: name"></span>s generate <span data-bind="text: output.energy"></span> energy, #=data.output.parts# parts, and #=data.output.territory# territory per second.</p>
        <p>Building one unit costs <b>#=data.cost.energy#</b> energy, <b>#=data.cost.parts#</b> parts, and <b>#=data.cost.territory#</b> territory, and require the recycling of <b>#= data.cost.sacrifice #</b> of your next lower level of units. </p>
        <p>You have enough resources to make <b data-bind="text: maxBuild"></b> #=data.name#s.</p>

        <button data-role="button"
                data-icon="plus"
                data-bind="click: buyUnit, enabled: available">Build</button>  
        
        <button data-role="button"
                data-icon="plus"
                data-bind="click: buyMaxUnit, enabled: available">Build <span data-bind="text: maxBuild"></span></button>  
    </div>

</script>



<script>

    function GetCurrentOutput(units, type){
        return units.unitData.reduce(function(prev, unit) {
            if (unit.owned > 0) {
                prev += (unit.output[type]*unit.owned) 
            }
            return prev;
        }, 0);
    }

    var gameState = kendo.observable({

        energy: 5,

        parts: 5,

        territory: 5,

        selectedUnit: null,

        available: function(e) {
            return (
                gameState.get("energy") > e.cost["energy"] &&
                gameState.get("parts") > e.cost["parts"] &&
                gameState.get("territory") > e.cost["territory"] &&
                this.get("maxBuild").call(this, e) > 0
            );
        },

        showUnit: function(e) {
            return (
                e.owned > 0 ||                
                this.get("maxBuild").call(this, e) > 0
            );
        },

        tabSelect: function(e) {
            $(e.contentElement).find("tr:last").trigger("click");
        },

        buyUnit: function(e, units = 1) {
            gameState.set("energy", this.get("energy")-(e.data.cost["energy"] * units));
            gameState.set("parts", this.get("parts")-(e.data.cost["parts"] * units));
            gameState.set("territory", this.get("territory")-(e.data.cost["territory"] * units));
            if (e.data.cost.sacrifice > 0) {                
                const collection = e.data.parent().parent();
                let idx = collection.unitData.map(function(x) {return x.name; }).indexOf(e.data.name);     
                let newCount = collection.unitData[idx+1].owned - (e.data.cost.sacrifice * units);       
                collection.unitData[idx+1].set("owned", newCount);                
            }
            e.data.set("owned", (e.data.owned+units));
        },

        buyMaxUnit: function(e) {
            const max = this.get("maxBuild").call(this, e.data);      
            this.get("buyUnit").call(this, e, max);
        },

        getProduction: function(unitType, type) {
            return GetCurrentOutput(gameState.get(unitType), type);
        },

      	unitSelect: function(e){     
            $(e.currentTarget).siblings().removeClass("k-state-selected");
            $(e.currentTarget).addClass("k-state-selected")
            this.set("selectedUnit", e.data.uid);
      	},

        unitSelected: function(e){         
            return this.get("selectedUnit") == e.uid;
      	},

        //calculate the maximum amount of a given unit can be built based on its costs and available resources
        maxBuild: function(unit) {
            const energyCount = Math.floor(this.get("energy") / unit.cost.energy);
            const partsCount = Math.floor(this.get("parts") / unit.cost.parts);
            const territoryCount = Math.floor(this.get("territory") / unit.cost.territory);
            let minCount =  Math.min(energyCount, partsCount, territoryCount);

            if (unit.cost.sacrifice > 0) {                
                let collection = unit.parent().parent();
                let idx = collection.unitData.map(function(x) {return x.name; }).indexOf(unit.name);     
                if (collection.unitData[idx+1].owned >= 0) {
                    let sacrificialCount = Math.floor(collection.unitData[idx+1].owned / unit.cost.sacrifice);
                    minCount = Math.min(minCount, sacrificialCount);
                }
                else {
                    minCount = 0;
                }
            }
            return minCount;
        },

        //Game unit data
        bots: {
            name: "bots", 
            title: "Units",
            unitData: [
                {
                    name: "Drone Factory",                    
                    description: "Drone factories house assembly lines. Each factory creates 1 Assembly line per second.",
                    cost: {
                        energy: 1000,
                        parts: 1000,
                        territory: 0,
                        sacrifice: 1000
                    },
                    output: {
                        energy: 0,
                        parts: 0,
                        territory: 0,
                        nextUnit: 1
                    }, 
                    owned: 0
                },   
                {
                    name: "Drone Assembly Line",
                    description: "A large collection of drone builder bots can get more work done. Each assembly line creates 1 Builder bot per second.",
                    cost: {
                        energy: 100,
                        parts: 100,
                        territory: 0,
                        sacrifice: 100
                    },
                    output: {
                        energy: 0,
                        parts: 0,
                        territory: 0,
                        nextUnit: 1
                    }, 
                    owned: 0
                },   
                {
                    name: "Drone Builder Bot",                     
                    description: "Basic assembly unit for creating new drones. Each one produces 1 drone per second on its own.",
                    cost: {
                        energy: 10,
                        parts: 10,
                        territory: 0,
                        sacrifice: 10
                    },
                    output: {
                        energy: 0,
                        parts: 0,
                        territory: 0,
                        nextUnit: 1
                    }, 
                    owned: 0
                }, 
                {
                    name: "Drone bot", 
                    description: "Drone bots seek out scrap metal which can be used to make parts for the fighter bots.",
                    cost: {
                        energy: 1,
                        parts: 1,
                        territory: 0,
                        sacrifice: 0
                    },
                    output: {
                        energy: 0,
                        parts: 1,
                        territory: 0,
                        nextUnit: 0
                    },
                    owned: 1
                },
            ],
        },

        energySources: {
            name: "energySources", 
            title: "Energy",
            unitData: [
                {
                    name: "Power Plant", 
                    cost: {
                        energy: 0,
                        parts: 1000,
                        territory: 1000,
                        sacrifice: 1000
                    },
                    output: {
                        energy: 1000,
                        parts: 0,
                        territory: 0
                    },
                    available: this.available,
                    owned: 0

                },   
                {
                    name: "Gas Generator", 
                    cost: {
                        energy: 0,
                        parts: 100,
                        territory: 100,
                        sacrifice: 100
                    },
                    output: {
                        energy: 100,
                        parts: 0,
                        territory: 0
                    },
                    available: this.available,
                    owned: 0

                },   
                {
                    name: "Solar Cell", 
                    cost: {
                        energy: 0,
                        parts: 10,
                        territory: 10,                        
                        sacrifice: 10
                    },
                    output: {
                        energy: 10,
                        parts: 0,
                        territory: 0
                    },
                    available: this.available,
                    owned: 0
                }, 
                {
                    name: "Battery, off-brand", 
                    cost: {
                        energy: 0,
                        parts: 1,
                        territory: 1,
                        sacrifice: 0
                    },
                    output: {
                        energy: 1,
                        parts: 0,
                        territory: 0
                    },
                    available: this.available,
                    owned: 1
                },
            ],
        }, 

        fighters: {
            name: "fighters",
            title: "Territory",
            unitData:  [
                {
                    name: "Giant Mech", 
                    cost: {
                        energy: 1000,
                        parts: 1000,
                        territory: 0,
                        sacrifice: 1000
                    },
                    output: {
                        energy: 0,
                        parts: 0,
                        territory: 1000
                    },
                    available: this.available,
                    owned: 0

                },  
                {
                    name: "ED-209", 
                    cost: {
                        energy: 100,
                        parts: 100,
                        territory: 0,
                        sacrifice: 100
                    },
                    output: {
                        energy: 0,
                        parts: 0,
                        territory: 100
                    },
                    available: this.available,
                    owned: 0

                },   
                {
                    name: "T-800", 
                    cost: {
                        energy: 10,
                        parts: 10,
                        territory: 0,
                        sacrifice: 10
                    },
                    output: {
                        energy: 0,
                        parts: 0,
                        territory: 10
                    }, 
                    available: this.available,
                    owned: 0
                }, 
                {
                    name: "Knife Equipped Roomba", 
                    cost: {
                        energy: 1,
                        parts: 1,
                        territory: 0,
                        sacrifice: 0
                    },
                    output: {
                        energy: 0,
                        parts: 0,
                        territory: 1
                    },
                    available: this.available,
                    owned: 1
                },
            ],
        },
           
    });

    $(document).on("ready", function(){

        //bind UI to MVVM data model
        kendo.bind($(".game"), gameState);

        //Start the "game loop", a 1 second timer that updates the state of the game data.
        setInterval(UpdateState, 1000);

    });

    //calculate the earned and available units of each type
    function UpdateState() {
        UpdateResource("energySources", "energy");
        UpdateResource("bots", "parts");
        UpdateResource("fighters", "territory");
        UpdateBuilders();
    }

    //function for getting a resource type and updating its value based on the calculated output of a given unit
    function UpdateResource(unitType, type) {
        gameState.set(type, gameState.get(type) + gameState.getProduction(unitType, type));        
    }

    //Calculate automatic production of new game units
    function UpdateBuilders() {
        //reverse the array order so the units arent added before their costs are calculated
        $.each($(gameState.get("bots.unitData")).toArray().reverse(), function(idx, unit) { 
            if(unit.output.nextUnit > 0) {                
                let unitsToAdd = unit.owned * unit.output.nextUnit;
                //only update if we need to, set method in kendo causes a lot of events to fire.
                if (unitsToAdd > 0)
                {
                    //get non-reversed idx
                    let idx = gameState.get("bots.unitData").map(function(x) {return x.name; }).indexOf(unit.name);                       
                    gameState.set("bots.unitData["+(idx+1)+"].owned", gameState.get("bots.unitData["+(idx+1)+"].owned") + unitsToAdd);                    
                    
                }
            }
        });
    }


</script>

<?php include 'footer.php'; ?>
