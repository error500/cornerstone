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





    } );

} )();