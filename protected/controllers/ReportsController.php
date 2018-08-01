<?php
/**
 * Reports Controller
 */

class ReportsController extends Controller {
  
    public function actionAllClosedEvents() {
        $this->render('allClosedEvents');
    }
    
    public function actionClosedUnscheduled() {
    	$this->render('closedUnscheduled');
    }
    
    public function actionPanelsW3() {
    	$this->render('panelsW3');
    }
    
    public function actionPanelsW2() {
    	$this->render('panelsW2');
    }
    
    public function actionPanelsPanelist() {
    	$this->render('panelsPanelist');
    }
    
    public function actionOpenYN() {
        $this->render('openYN');
    }
    
    public function actionCompactSchedules() {
        $this->render('compactSchedules');
    }
    
    public function actionPanelDescriptions() {
        $this->render('panelDescriptions');
    }
    
    public function actionPanelistUnavailability() {
        $this->render('panelistUnavailability');
    }
    
    public function actionPanelistsNumber() {
        $this->render('panelistsNumber');
    }
    
    public function actionPanelsRoom() {
        $this->render('panelsRoom');
    }
    
    public function actionPanelsTime() {
        $this->render('panelsTime');
    }
    
    public function actionPanelsProgram() {
        $this->layout = '//layouts/blank';
        $this->render('panelsProgram');
    }
    
    public function actionPrintableSchedules() {
        $this->layout = '//layouts/blank';
        $this->render('printableSchedules');
    }
    
    public function actionGuidebook() {
        $this->layout = '//layouts/blank';
        $this->render('guidebook');
    }
    
    public function actionExcel() {
        $this->layout = '//layouts/blank';
        $this->render('excel');
    }
    
    public function actionExcelAV() {
        $this->layout = '//layouts/blank';
        $this->render('excelAV');
    }
    
    public function actionRoomSchedule() {
        $this->layout = '//layouts/blank';
        $this->render('roomSchedule');
    }
    
    public function actionContactInfo() {
        $this->layout = '//layouts/blank';
        $this->render('contactInfo');
    }
    
    public function actionAdult() {
    	$this->layout = '//layouts/blank';
    	$this->render('adult');
    }
    
    public function actionPanelistNames() {
    	$this->layout = '//layouts/blank';
    	$this->render('panelistNames');
    }
}
?>