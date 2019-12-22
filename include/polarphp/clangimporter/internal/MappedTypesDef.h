//===--- MappedTypes.def - Automatically Mapped Type Database ---*- C++ -*-===//
//
// This source file is part of the Swift.org open source project
//
// Copyright (c) 2014 - 2017 Apple Inc. and the Swift project authors
// Licensed under Apache License v2.0 with Runtime Library Exception
//
// See https://swift.org/LICENSE.txt for license information
// See https://swift.org/CONTRIBUTORS.txt for the list of Swift project authors
//
//===----------------------------------------------------------------------===//
//
// This file defines the database of C types that are imported as swift stdlib
// types.
//
// MAP_TYPE(C_TYPE_NAME, C_TYPE_KIND, C_TYPE_BITWIDTH,
//          SWIFT_MODULE_NAME, SWIFT_TYPE_NAME,
//          CAN_BE_MISSING, C_NAME_MAPPING)
//  - C_TYPE_NAME is the name of the C type.
//  - C_TYPE_KIND is the expected kind of the C type (see MappedCTypeKind
//    enum).
//  - C_TYPE_BITWIDTH is the expected size of the C type; a zero value
//    means "don't check".
//  - SWIFT_MODULE_NAME is the name of the swift library module.
//  - SWIFT_TYPE_NAME is the name of the corresponding stdlib type.
//  - CAN_BE_MISSING is true if it is OK for swift type to be missing in the
//    stdlib.
//  - C_NAME_MAPPING specifies if we should create a typealias in the
//    imported Clang module (see MappedTypeNameKind enum).
//
//===----------------------------------------------------------------------===//

#define MAP_STDLIB_TYPE(C_TYPE_NAME, C_TYPE_KIND, C_TYPE_BITWIDTH,  \
                        SWIFT_TYPE_NAME, CAN_BE_MISSING,            \
                        C_NAME_MAPPING)                             \
    MAP_TYPE(C_TYPE_NAME, C_TYPE_KIND, C_TYPE_BITWIDTH,             \
             "Swift", SWIFT_TYPE_NAME, CAN_BE_MISSING,              \
             C_NAME_MAPPING)

// MacTypes.h defines typedefs UIntXX, SIntXX, FloatXX.
MAP_STDLIB_TYPE("UInt8",  UnsignedInt, 8,  "UInt8",  false, DoNothing)
MAP_STDLIB_TYPE("UInt16", UnsignedInt, 16, "UInt16", false, DoNothing)
MAP_STDLIB_TYPE("UInt32", UnsignedInt, 32, "UInt32", false, DoNothing)
MAP_STDLIB_TYPE("UInt64", UnsignedInt, 64, "UInt64", false, DoNothing)

MAP_STDLIB_TYPE("SInt8",  SignedInt, 8,  "Int8",  false, DoNothing)
MAP_STDLIB_TYPE("SInt16", SignedInt, 16, "Int16", false, DoNothing)
MAP_STDLIB_TYPE("SInt32", SignedInt, 32, "Int32", false, DoNothing)
MAP_STDLIB_TYPE("SInt64", SignedInt, 64, "Int64", false, DoNothing)

MAP_STDLIB_TYPE("Float32", FloatIEEEsingle,        32, "Float32", false,
                DoNothing)
MAP_STDLIB_TYPE("Float64", FloatIEEEdouble,        64, "Float64", false,
                DoNothing)
MAP_STDLIB_TYPE("Float80", FloatX87DoubleExtended, 80, "Float80", true,
                DoNothing)

MAP_STDLIB_TYPE("Byte",       UnsignedInt, 8,  "UInt8", false, DoNothing)
MAP_STDLIB_TYPE("SignedByte", SignedInt,   8,  "Int8",  false, DoNothing)

MAP_STDLIB_TYPE("ItemCount", UnsignedWord, 0, "Int", false, DoNothing)
MAP_STDLIB_TYPE("ByteCount", UnsignedWord, 0, "Int", false, DoNothing)
MAP_STDLIB_TYPE("UniCharCount", UnsignedWord, 0, "Int", false, DoNothing)

MAP_TYPE("Boolean", UnsignedInt, 8, "Darwin", "DarwinBoolean", true,
DoNothing)


// stdint.h types.
MAP_STDLIB_TYPE("uint8_t",  UnsignedInt, 8,  "UInt8",  false, DoNothing)
MAP_STDLIB_TYPE("uint16_t", UnsignedInt, 16, "UInt16", false, DoNothing)
MAP_STDLIB_TYPE("uint32_t", UnsignedInt, 32, "UInt32", false, DoNothing)
MAP_STDLIB_TYPE("uint64_t", UnsignedInt, 64, "UInt64", false, DoNothing)

MAP_STDLIB_TYPE("int8_t",  SignedInt, 8,  "Int8",  false, DoNothing)
MAP_STDLIB_TYPE("int16_t", SignedInt, 16, "Int16", false, DoNothing)
MAP_STDLIB_TYPE("int32_t", SignedInt, 32, "Int32", false, DoNothing)
MAP_STDLIB_TYPE("int64_t", SignedInt, 64, "Int64", false, DoNothing)

MAP_STDLIB_TYPE("intptr_t",  SignedWord,   0, "Int",  false, DefineOnly)
MAP_STDLIB_TYPE("uintptr_t", UnsignedWord, 0, "UInt", false, DefineOnly)

// SwiftStdint.h defines its own copy of stdint.h types.
MAP_STDLIB_TYPE("__polarphp_uint8_t", UnsignedInt, 8, "UInt8", false,
                DoNothing)
MAP_STDLIB_TYPE("__polarphp_uint16_t", UnsignedInt, 16, "UInt16", false,
                DoNothing)
MAP_STDLIB_TYPE("__polarphp_uint32_t", UnsignedInt, 32, "UInt32", false,
                DoNothing)
MAP_STDLIB_TYPE("__polarphp_uint64_t", UnsignedInt, 64, "UInt64", false,
                DoNothing)

MAP_STDLIB_TYPE("__polarphp_int8_t", SignedInt, 8, "Int8", false, DoNothing)
MAP_STDLIB_TYPE("__polarphp_int16_t", SignedInt, 16, "Int16", false,
                DoNothing)
MAP_STDLIB_TYPE("__polarphp_int32_t", SignedInt, 32, "Int32", false,
                DoNothing)
MAP_STDLIB_TYPE("__polarphp_int64_t", SignedInt, 64, "Int64", false,
                DoNothing)

MAP_STDLIB_TYPE("__polarphp_intptr_t", SignedWord, 0, "Int", false,
                DefineOnly)
MAP_STDLIB_TYPE("__polarphp_uintptr_t", UnsignedWord, 0, "UInt", false,
                DefineOnly)

// stddef.h types.
MAP_STDLIB_TYPE("ptrdiff_t", SignedWord,   0, "Int",  false, DefineOnly)
MAP_STDLIB_TYPE("size_t",    UnsignedWord, 0, "Int",  false, DefineOnly)
MAP_STDLIB_TYPE("rsize_t",   UnsignedWord, 0, "Int",  false, DefineOnly)

// SwiftStddef.h defines its own copy of stddef.h types.
MAP_STDLIB_TYPE("__polarphp_ptrdiff_t", SignedWord, 0, "Int", false,
                DefineOnly)
MAP_STDLIB_TYPE("__polarphp_size_t", UnsignedWord, 0, "Int", false,
                DefineOnly)
MAP_STDLIB_TYPE("__polarphp_ssize_t", SignedWord, 0, "Int", false,
                DefineOnly)

// POSIX sys/types.h.
MAP_STDLIB_TYPE("ssize_t", SignedWord, 0, "Int", false, DefineOnly)
MAP_STDLIB_TYPE("u_int8_t",  UnsignedInt, 8,  "UInt8",  false, DoNothing)
MAP_STDLIB_TYPE("u_int16_t", UnsignedInt, 16, "UInt16", false, DoNothing)
MAP_STDLIB_TYPE("u_int32_t", UnsignedInt, 32, "UInt32", false, DoNothing)
MAP_STDLIB_TYPE("u_int64_t", UnsignedInt, 64, "UInt64", false, DoNothing)

// stdarg.h types.
// Note: this does not catch va_list on platforms where va_list is an array.
// There's an explicit workaround in ImportType.cpp's VisitDecayedType for that.
MAP_STDLIB_TYPE("va_list", VaList, 0, "CVaListPointer", false, DoNothing)
MAP_STDLIB_TYPE("__gnuc_va_list", VaList, 0, "CVaListPointer", false, DoNothing)
MAP_STDLIB_TYPE("__va_list", VaList, 0, "CVaListPointer", false, DoNothing)

// libkern/OSTypes.h types.
MAP_STDLIB_TYPE("UInt", UnsignedInt, 32, "CUnsignedInt", false, DoNothing)
MAP_STDLIB_TYPE("SInt", SignedInt, 32, "CInt", false, DoNothing)

// Dispatch types.
MAP_TYPE("dispatch_block_t", Block, 0, "Dispatch", "dispatch_block_t",
true, DoNothing)
MAP_TYPE("__polarphp_shims_dispatch_block_t", Block, 0, "Dispatch", "_DispatchBlock",
true, DoNothing)
MAP_TYPE("__polarphp_shims_dispatch_data_t", ObjCId, 0, "Dispatch", "dispatch_data_t",
true, DoNothing)

// Objective-C types.
MAP_TYPE("SEL",  ObjCSel, 0, "ObjectiveC", "Selector", false, DoNothing)
MAP_STDLIB_TYPE("Class", ObjCClass, 0, "AnyClass", false, DoNothing)
MAP_STDLIB_TYPE(
   Impl.SwiftContext.getSwiftName(KnownFoundationEntity::NSInteger),
   SignedWord, 0, "Int", false, DefineOnly)

// Treat NSUInteger specially: exposing it as a typealias for "Int" would be
// confusing.
MAP_STDLIB_TYPE(
   Impl.SwiftContext.getSwiftName(KnownFoundationEntity::NSUInteger),
   UnsignedWord, 0, "Int", false, DoNothing)

// CoreGraphics types.
MAP_TYPE("CGFloat", CGFloat, 0, "CoreGraphics", "CGFloat", false, DoNothing)

// CoreFoundation types.
// Note that we're preserving the typealias for CFIndex.
MAP_STDLIB_TYPE("CFTypeID", UnsignedWord, 0, "UInt", false, DefineAndUse)
MAP_STDLIB_TYPE("CFOptionFlags", UnsignedWord, 0, "UInt", false, DefineAndUse)
MAP_STDLIB_TYPE("CFHashCode", UnsignedWord, 0, "UInt", false, DefineAndUse)
MAP_STDLIB_TYPE("CFIndex", SignedWord, 0, "Int", false, DefineAndUse)

// Foundation types.
// FIXME: <rdar://problem/16074941> NSStringEncoding doesn't work on 32-bit
MAP_STDLIB_TYPE("NSStringEncoding", UnsignedWord, 0, "UInt", false, DoNothing)

#undef MAP_STDLIB_TYPE
#undef MAP_TYPE
