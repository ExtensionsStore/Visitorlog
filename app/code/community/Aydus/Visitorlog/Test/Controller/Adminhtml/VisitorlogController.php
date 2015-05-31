<?php

/**
 * 
 *
 * @category   Aydus
 * @package    Aydus_Visitorlog
 * @author     Aydus <davidt@aydus.com>
 */
class Aydus_Visitorlog_Test_Controller_Adminhtml_VisitorlogController 
    extends EcomDev_PHPUnit_Test_Case_Controller {

    /**
     * Mock session
     * 
     * @loadFixture testAdmin.yaml
     */
    public function setUp() {
        
        $this->reset();
        $sessionMock = $this->getModelMockBuilder('admin/session')
                        ->disableOriginalConstructor()->setMethods(null)->getMock();
        $this->replaceByMock('singleton', 'admin/session', $sessionMock);

        $adminUserId = 1;
        $adminUser = Mage::getSingleton('admin/user');
        $adminUser->load($adminUserId);

        $adminSession = Mage::getSingleton('admin/session');
        $adminSession->setIsFirstVisit(true);
        $adminSession->setUser($adminUser);
        $adminSession->setAcl(Mage::getResourceModel('admin/acl')->loadAcl());
        Mage::dispatchEvent('admin_session_user_login_success', array('user' => $adminUser));

        $mock = $this->getBlockMock('index/adminhtml_notifications', array('getProcessesForReindex'));

        $mock->expects($this->any())
                ->method('getProcessesForReindex')
                ->will($this->returnValue(array()));

        $this->replaceByMock('block', 'index/adminhtml_notifications', $mock);
    }

    /**
     * @test
     * @loadFixture testAdmin.yaml
     */
    public function indexAction() {

        echo "\nStarted Aydus_Visitorlog controller test.";
        
        $this->dispatch('adminhtml/visitorlog/index');
        $this->assertLayoutHandleLoaded('adminhtml_visitorlog_index');
        $this->assertLayoutBlockCreated('visitorlog');
    }

    /**
     * @test
     * @loadFixture testAdmin.yaml
     */
    public function gridAction() {

        $this->dispatch('adminhtml/visitorlog/grid');
        $this->assertLayoutHandleLoaded('adminhtml_visitorlog_grid');
        $this->assertLayoutBlockCreated('visitorlog_grid');
    }

    /**
     * @test
     * @loadFixture testAdmin.yaml
     */
    public function viewAction() {

        $this->dispatch('adminhtml/visitorlog/view', array('id' => 1));
        $this->assertLayoutHandleLoaded('adminhtml_visitorlog_view');
        $this->assertLayoutBlockCreated('visitorlog_view');
    }

    /**
     * @test
     * @loadFixture testAdmin.yaml
     */
    public function urlsAction() {
        
        Mage::unregister('current_visitor');
        
        $this->dispatch('adminhtml/visitorlog/urls', array('id' => 1));
        $this->assertLayoutHandleLoaded('adminhtml_visitorlog_urls');
        $this->assertLayoutBlockCreated('visitorlog_view_tab_url');
    }

    /**
     * @test
     * @loadFixture testAdmin.yaml
     */
    public function geoipAction() {

        $this->dispatch('adminhtml/geoip/index');
        $this->assertLayoutHandleLoaded('adminhtml_geoip_index');
        $this->assertLayoutBlockCreated('visitorlog.geoip.container');

        echo "\nCompleted Aydus_Visitorlog controller test.";
    }

}
