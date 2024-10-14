(function() {
  
  tinymce.create('tinymce.plugins.PreButton', {
    /**
     * Initializes the plugin, this will be executed after the plugin has been created.
     * This call is done before the editor instance has finished it's initialization so use the onInit event
     * of the editor instance to intercept that event.
     *
     * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
     * @param {string} url Absolute URL to where the plugin is located.
     */
    init : function(ed, url) {
      ed.addCommand('preFormat', function() {
        ed.formatter.toggle('pre');
      });
      
      ed.addButton('pre', {
        title : 'Pre',
        cmd : 'preFormat',
        image : url + '/pre.png'
      });
      
      ed.addShortcut('ctrl+0','pre','preFormat')
    },
  });

  // Register plugin
  tinymce.PluginManager.add('preButton', tinymce.plugins.PreButton);
  
})();