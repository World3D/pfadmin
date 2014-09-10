/**
 * PLAIN FRAMEWORK ( https://github.com/viticm/plainframework )
 * $Id ${filename}.h
 * @link https://github.com/viticm/plainframework for the canonical source repository
 * @copyright Copyright (c) 2014- viticm( viticm.ti@gmail.com )
 * @license
 * @user viticm<viticm.ti@gmail.com>
 * @date ${date}
 * @uses ${description}
 */
#ifndef COMMON_NET_PACKET_${macro}_H_
#define COMMON_NET_PACKET_${macro}_H_

#include "common/net/packet/${module}/config.h"
#include "pf/net/connection/base.h"
#include "pf/net/packet/base.h"
#include "pf/net/packet/factory.h"
#include "common/define/macros.h"

namespace common {

namespace net {

namespace packet {

namespace ${module} {

class ${classname} : public pf_net::packet::Base {

 public:
   ${classname}();
   virtual ~${classname}() {};

 public:  
   virtual bool read(pf_net::socket::InputStream &inputstream);
   virtual bool write(pf_net::socket::OutputStream &outputstream) const;
   virtual uint32_t execute(pf_net::connection::Base *connection);
   virtual uint16_t getid() const;
   virtual uint32_t getsize() const;
   
 public: 
   ${functions}

 private:
   ${variables}

};

class ${classname}Factory : public pf_net::packet::Factory {

 public:
   pf_net::packet::Base *createpacket();
   uint16_t get_packetid() const;
   uint32_t get_packet_maxsize() const;

};

class ${classname}Handler {

 public:
   static uint32_t execute(${classname} *packet, 
                           pf_net::connection::Base *connection);

};

}; //namespace ${module}

}; //namespace packet

}; //namespace net

}; //namespace common

#endif //COMMON_NET_PACKET_${macro}_H_
