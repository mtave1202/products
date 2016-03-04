Vagrant.configure(2) do |config|

  config.vm.box = "centos6_5"
  config.vm.box_url = "https://github.com/2creatives/vagrant-centos/releases/download/v6.5.3/centos65-x86_64-20140116.box"
  config.vm.box_check_update = false
  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "private_network", ip: "192.168.56.10"
  config.vm.synced_folder "./products", "/vagrant/products", owner: "vagrant", group: "vagrant", mount_options:["dmode=777","fmode=777"]
  config.vm.provider "virtualbox" do |vb|
     vb.memory = "1024"
  end

  Encoding.default_external = 'UTF-8'
  #config.vm.provision "shell", :path => "./provision.sh"
end

