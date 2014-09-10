#include "pf/base/string.h"
#include "common/define/net/packet/id/${id_module}.h"
#include "common/define/enum.h"
#include "common/net/packet/${module}/${filename}.h"

using namespace pf_net::socket;
using namespace common::net::packet::${module};

${classname}::${classname}() {
  __ENTER_FUNCTION
    ${construct_implement}
  __LEAVE_FUNCTION
}

bool ${classname}::read(InputStream &inputstream) {
  __ENTER_FUNCTION
    ${read_implement}
    return true;
  __LEAVE_FUNCTION
    return false;
}

bool ${classname}::write(OutputStream &outputstream) const {
  __ENTER_FUNCTION
    ${write_implement}
    return true;
  __LEAVE_FUNCTION
    return false;
}

uint32_t ${classname}::execute(
    pf_net::connection::Base* connection) {
  __ENTER_FUNCTION
    uint32_t result = 0;
    result = ${classname}Handler::execute(this, connection);
    return result;
  __LEAVE_FUNCTION
    return 0;
}

uint16_t ${classname}::getid() const {
  using namespace 
    common::define::net::packet::id::${module}; 
  return k${classname};
}

uint32_t ${classname}::getsize() const {
  uint32_t result = ${size_implement}
  return result;
}

${functions_implement}

pf_net::packet::Base *${classname}Factory::createpacket() {
  __ENTER_FUNCTION
    pf_net::packet::Base *result = new ${classname}();
    return result;
  __LEAVE_FUNCTION
    return NULL;
}

uint16_t ${classname}Factory::get_packetid() const {
  using namespace 
    common::define::net::packet::id::${module}; 
  return k${classname};
}

uint32_t ${classname}Factory::get_packet_maxsize() const {
  uint32_t result = ${maxsize_implement}
  return result;
}
