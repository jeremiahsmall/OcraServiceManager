<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace OcraServiceManagerTest\ServiceFactory;

use Zend\ServiceManager\ServiceManager;
use PHPUnit_Framework_TestCase;
use OcraServiceManager\ServiceFactory\EventManagerFactory;
use Zend\EventManager\EventManagerInterface;

/**
 * @author  Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class EventManagerFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \OcraServiceManager\ServiceFactory\EventManagerFactory::createService
     */
    public function testCreateService()
    {
        $factory        = new EventManagerFactory();
        $serviceLocator = $this->getMock('Zend\\ServiceManager\\ServiceLocatorInterface');
        $listenerMock   = $this->getMock('Zend\\EventManager\\ListenerAggregateInterface');
        $listenerMock
            ->expects($this->once())
            ->method('attach')
            ->with($this->callback(function ($eventManager) {
                return $eventManager instanceof EventManagerInterface;
            }));
        $serviceLocator
            ->expects($this->any())
            ->method('get')
            ->with('OcraServiceManager\\ServiceManager\\Logger')
            ->will($this->returnValue($listenerMock));

        $this->assertInstanceOf('Zend\EventManager\EventManagerInterface', $factory->createService($serviceLocator));
    }
}
