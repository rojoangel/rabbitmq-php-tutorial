#Location of rabbitmq.config and rabbitmq-env.conf
/etc/rabbitmq/

#Useful commands:
    sudo rabbitmqctl list_queues
    sudo rabbitmqctl list_queues name messages_ready messages_unacknowledged
    sudo rabbitmqctl list_exchanges
    sudo rabbitmqctl list_bindings

    sudo rabbitmqctl stop_app
    sudo rabbitmqctl reset
    sudo rabbitmqctl start_app
    
#Plugins
    rabbitmq-plugins enable plugin-name
    rabbitmq-plugins disable plugin-name
    rabbitmq-plugins list
    
    