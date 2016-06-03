( function() {
    tinymce.PluginManager.add( 'cornerstone_buttons', function( editor, url ) {

        // Add a button that opens a window
        editor.addButton( 'cornerstone_column', {

            text: 'Colonnes',
            icon: false,
            onclick: function() {
                // Open window
                editor.windowManager.open( {
                    title: 'Affichage en colonnes',
                    body: [{
                        type: 'listbox',
                        name: 'format',
                        label: 'Format de colonnes',
                        'values': [
                            {text: '6-6 : Deux colonnes', value: 'twocols'},
                            {text: '4-4-4 Trois colonnes', value: 'threecols'},
                            {text: '3-3-3-3 Quatre colonnes', value: 'fourcols'},
                            {text: '2-4-2-4 Deux colonnes et marge (cachées en small)', value: 'twocolsmargin'}
                        ]
                    }],
                    onsubmit: function( e ) {
                        switch(e.data.format ) {
                            case 'twocols' :
                                editor.insertContent( '[column class="small-12 medium-6" status=first] column1[/column]');
                                editor.insertContent( '[column class="small-12 medium-6" status=last] column2[/column]');
                                break;
                            case 'threecols' :
                                nbcols = 12/e.data.column;
                                editor.insertContent( '[column class="small-12 medium-4" status=first] column1[/column]');
                                editor.insertContent( '[column class="small-12 medium-4" ] column2[/column]');                                
                                editor.insertContent( '[column class="small-12 medium-4" status=last] column3[/column]');
                                break;
                            case 'fourcols' :
                                nbcols = 12/e.data.column;
                                editor.insertContent( '[column class="small-12 medium-3" status=first] column1[/column]');
                                editor.insertContent( '[column class="small-12 medium-3" ] column2[/column]');                                
                                editor.insertContent( '[column class="small-12 medium-3" ] column3[/column]');                                                                
                                editor.insertContent( '[column class="small-12 medium-3" status=last] column4[/column]');
                                break;
                            case 'twocolsmargin' :
                                nbcols = 12/e.data.column;
                                editor.insertContent( '[column class="hide-for-small-only medium-2" status=first] Marge[/column]');
                                editor.insertContent( '[column class="small-12 medium-4" ] column1[/column]');                                
                                editor.insertContent( '[column class="hide-for-small-only medium-2" ] Marge[/column]');                                                                
                                editor.insertContent( '[column class="small-12 medium-4" status=last] column2[/column]');
                                break;   
                            default :
                                alert("Format non traité");
                        }
                        
                    }

                } );
            }

        } );

        editor.addButton( 'cornerstone_magellan', {

            text: 'Magellan',
            icon: false,
            onclick: function() {
                // Open window
                editor.windowManager.open( {
                    title: 'Navigation Magellan',
                    body: [{
                        type: 'listbox',
                        name: 'format',
                        label: 'Format de colonnes',
                        'values': [
                            {text: 'Deux titres', value: 'twotitles'},
                            {text: 'Trois titres', value: 'threetitles'}
                        ]
                    }],
                    onsubmit: function( e ) {
                        switch(e.data.format ) {
                            case 'twotitles' :
                                editor.insertContent( '[magellan_bar anchor_list=Premier,Second]');
                                editor.insertContent( '[magellan] Premier[/magellan] Lorem ipsum dolor....<br/>');
                                editor.insertContent( '[magellan] Second[/magellan] Lorem ipsum dolor....<br/>');
                                break;
                            case 'threetitles' :
                                nbcols = 12/e.data.column;
                                editor.insertContent( '[magellan_bar anchor_list=Premier,Second,troisieme]');
                                editor.insertContent( '[magellan] Premier[/magellan] Lorem ipsum dolor....<br/>');
                                editor.insertContent( '[magellan] Second[/magellan] Lorem ipsum dolor....<br/>');
                                editor.insertContent( '[magellan] troisieme[/magellan] Lorem ipsum dolor....<br/>');
                                break;
                            
                            default :
                                alert("Format non traité");
                        }
                        
                    }

                } );
            }

        } );
        editor.addButton( 'cornerstone_clearing', {

            text: 'Clearing',
            icon: false,
            onclick: function() {
                // Open window
                editor.windowManager.open( {
                    title: 'Clearing',
                    body: [{
                        type: 'listbox',
                        name: 'format',
                        label: 'Format de vignettes',
                        'values': [
                            {text: 'Trois vignettes', value: 'threethumbs'},
                            {text: 'Quatre titres', value: 'fourthumbs'}
                        ]
                    }],
                    onsubmit: function( e ) {
                        switch(e.data.format ) {
                            case 'threethumbs' :
                                editor.insertContent( '[clearing status=first path=http://lorempixel.com/1400/800/sports/ caption=sport1 paththumb=http://lorempixel.com/150/150/sports/ ]');
                                editor.insertContent( '[clearing  path=http://lorempixel.com/1400/800/sports/ caption=sport2 paththumb=http://lorempixel.com/150/150/sports/ ]<br/>');
                                editor.insertContent( '[clearing status=last path=http://lorempixel.com/1400/800/sports/ caption=sport3 paththumb=http://lorempixel.com/150/150/sports/ ]');
                                break;
                            case 'fourthumbs' :
                                editor.insertContent( '[clearing status=first path=http://lorempixel.com/400/200/sports/ caption=sport1 paththumb=http://lorempixel.com/150/150/sports/ ]');
                                editor.insertContent( '[clearing  path=http://lorempixel.com/1400/800/sports/ caption=sport2 paththumb=http://lorempixel.com/150/150/sports/ ]<br/>');
                                editor.insertContent( '[clearing  path=http://lorempixel.com/1400/800/sports/ caption=sport3 paththumb=http://lorempixel.com/150/150/sports/ ]<br/>');
                                editor.insertContent( '[clearing status=last path=http://lorempixel.com/1400/800/sports/ caption=sport4 paththumb=http://lorempixel.com/150/150/sports/ ]');
                                break;
                            
                            default :
                                alert("Format non traité");
                        }
                        
                    }

                } );
            }

        } );    
        editor.addButton( 'cornerstone_grid', {

            text: 'Grid',
            icon: false,
            onclick: function() {
                // Open window
                editor.windowManager.open( {
                    title: 'Grid',
                    body: [{
                        type: 'listbox',
                        name: 'format',
                        label: 'Format de grid',
                        'values': [
                            {text: 'Trois grid', value: 'threegrids'},
                        ]
                    }],
                    onsubmit: function( e ) {
                        switch(e.data.format ) {
                            case 'threegrids' :
                                editor.insertContent( '[grid status=first class="small-4"] The content of the first grid[/grid]');
                                editor.insertContent( '[grid class="small-block-grid-2 medium-block-grid-3 large-block-grid-4"] The content of the second grid[/grid]<br/>');
                                editor.insertContent( '[grid status=last class="small-4"] The content of the third grid[/grid]');
                                break;
                            default :
                                alert("Format non traité");
                        }
                        
                    }

                } );
            }

        } );    
        editor.addButton( 'cornerstone_loop', {

            text: 'Boucle',
            icon: false,
            onclick: function() {
                // Open window
                editor.windowManager.open( {
                    title: 'Boucle d\'extraits',
                    body: [{
                        type: 'listbox',
                        name: 'format',
                        label: 'Boucle',
                        'values': [
                            {text: 'Trois derniers posts', value: 'threetlastpost'},
                            {text: 'Posts spécifiés', value: 'specifiedposts'},
                            {text: 'Le dernier posts centré', value: 'centeredlastpost'},
                            {text: 'Le dernier posts centré et template dédié', value: 'centeredlastpostspecifiedtemplate'}
                        ]
                    }],
                    onsubmit: function( e ) {
                        switch(e.data.format ) {
                            case 'threetlastpost' :
                                editor.insertContent( '[loop filter_by=post_type filter_value=post posts_per_page=3 orderby=date order=DESC class=small-block-grid-3]');
                                break;
                            case 'specifiedposts' :
                                editor.insertContent( '[loop filter_by=post filter_value=16,18]');
                                break;
                            case 'centeredlastpost' :
                                editor.insertContent( '[loop filter_by=post_type filter_value=post posts_per_page=1 orderby=date order=DESC grid_mode=grid class=small-12,medium-6,medium-centered,columns]');
                                break;
                            case 'centeredlastpostspecifiedtemplate' :
                                editor.insertContent( '[loop filter_by=post_type filter_value=post posts_per_page=1 orderby=date order=DESC grid_mode=grid class=small-12,medium-6,medium-centered,columns template=mytemp]');
                                break;                                
                            default :
                                alert("Format non traité");
                        }
                        
                    }

                } );
            }

        } );  




    } );

} )();