<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * TomatoCart
 *
 * An open source application ecommerce framework
 *
 * @package   TomatoCart
 * @author    TomatoCart Dev Team
 * @copyright Copyright (c) 2011, TomatoCart, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html
 * @link    http://tomatocart.com
 * @since   Version 0.5
 * @filesource ./system/modules/newsletters/views/main.php
 */

  echo 'Ext.namespace("Toc.newsletters");';
?>

Ext.override(Toc.desktop.NewslettersWindow, {

  createWindow: function(){
    var desktop = this.app.getDesktop();
    var win = desktop.getWindow('newsletters-win');
     
    if(!win){
      var grd = Ext.create('Toc.newsletters.NewslettersGrid');
      
      this.registGrdEvents(grd);
      
      win = desktop.createWindow({
        id: 'newsletters-win',
        title: '<?php echo lang('heading_newsletters_title'); ?>',
        width: 800,
        height: 400,
        iconCls: 'icon-newsletters-win',
        layout: 'fit',
        items: grd
      });
    }

    win.show();
  },
  
  registGrdEvents: function(grd) {
    grd.on('notifysuccess', this.onShowNotification, this);
    grd.on('create', function() {this.onCreateNewsletters(grd);}, this);
    grd.on('edit', function(record) {this.onEditNewsletters(grd, record);}, this);
    grd.on('sendemails', function(newslettersId) {this.onSendEmails(grd, newslettersId);}, this);
    grd.on('log', this.onLog, this);
    grd.on('sendnewsletters', function(newslettersId) {this.onSendNewsletters(grd, newslettersId);}, this);
  },
  
  onCreateNewsletters: function(grd) {
    var dlg = this.createNewslettersDialog();
    
    this.onSaveSuccess(dlg, grd);
    
    dlg.show();
  },
  
  onEditNewsletters: function (grd, record) {
    var dlg = this.createNewslettersDialog();
    dlg.setTitle(record.get('title'));
    
    this.onSaveSuccess(dlg, grd);
    
    dlg.show(record.get('newsletters_id'));
  },
  
  onSendEmails: function(grd, newslettersId) {
    var dlg = this.createSendEmailsDialog();
    
    this.onSendSuccess(dlg, grd);
    
    dlg.show(newslettersId);
  },
  
  onSendNewsletters: function(grd, newslettersId) {
    var dlg = this.createSendNewslettersDialog();
    
    this.onSendSuccess(dlg, grd);
    
    dlg.show(newslettersId);
  },
  
  onLog: function(record) {
    var dlg = this.createLogDialog();
    
    dlg.show(record.get('newsletters_id'));
  },  
  
  createSendEmailsDialog: function() {
    var desktop = this.app.getDesktop();
    var dlg = desktop.getWindow('send-emails-dialog-win');
    
    if (!dlg) {
      dlg = desktop.createWindow({}, Toc.newsletters.SendEmailsDialog);
    }
      
    return dlg;
  },
  
  createNewslettersDialog: function() {
    var desktop = this.app.getDesktop();
    var dlg = desktop.getWindow('newsletters-dialog-win');
    
    if (!dlg) {
      dlg = desktop.createWindow({}, Toc.newsletters.NewslettersDialog);
    }
      
    return dlg;
  },
  
  createLogDialog: function() {
    var desktop = this.app.getDesktop();
    var dlg = desktop.getWindow('log-dialog-win');
    
    if (!dlg) {
      dlg = desktop.createWindow({}, Toc.newsletters.LogDialog);
    }
      
    return dlg;
  },
  
  createSendNewslettersDialog: function() {
    var desktop = this.app.getDesktop();
    var dlg = desktop.getWindow('send-newsletters-dialog-win');
    
    if (!dlg) {
      dlg = desktop.createWindow({}, Toc.newsletters.SendNewslettersDialog);
    }
      
    return dlg;
  },
  
  onSaveSuccess: function(dlg, grd) {
    dlg.on('savesuccess', function(feedback) {
      this.onShowNotification(feedback);
      
      grd.onRefresh();
    }, this);
  },
  
  onSendSuccess: function(dlg, grd) {
    dlg.on('sendsuccess', function(feedback) {
      this.onShowNotification(feedback);
      
      grd.onRefresh();
    }, this);
  },
  
  onShowNotification: function(feedback) {
    this.app.showNotification({
      title: TocLanguage.msgSuccessTitle,
      html: feedback
    });
  }
});

/* End of file main.php */
/* Location: ./system/modules/newsletters/views/main.php */
