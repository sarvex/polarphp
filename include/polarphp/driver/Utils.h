//===--- Util.h - Common Driver Utilities -----------------------*- C++ -*-===//
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

#ifndef POLARPHP_DRIVER_UTILS_H
#define POLARPHP_DRIVER_UTILS_H

#include "polarphp/basic/FileTypes.h"
#include "polarphp/basic/LLVM.h"
#include "llvm/ADT/SmallVector.h"

namespace llvm {
namespace opt {
class Arg;
} // end namespace opt
} // end namespace llvm

namespace polar {

namespace driver {
/// An input argument from the command line and its inferred type.
using InputPair = std::pair<filetypes::FileTypeId, const llvm::opt::Arg *>;
/// Type used for a list of input arguments.
using InputFileList = SmallVector<InputPair, 16>;

enum class LinkKind {
   None,
   Executable,
   DynamicLibrary,
   StaticLibrary
};

/// Used by a Job to request a "filelist": a file containing a list of all
/// input or output files of a certain type.
///
/// The Compilation is responsible for generating this file before running
/// the Job this info is attached to.
struct FilelistInfo {
   enum class WhichFiles : unsigned {
      InputJobs,
      SourceInputActions,
      InputJobsAndSourceInputActions,
      Output,
      /// Batch mode frontend invocations may have so many supplementary
      /// outputs that they don't comfortably fit as command-line arguments.
      /// In that case, add a FilelistInfo to record the path to the file.
      /// The type is ignored.
         SupplementaryOutput,
   };

   StringRef path;
   filetypes::FileTypeId type;
   WhichFiles whichFiles;
};

} // end namespace driver
} // end namespace polar

#endif // POLARPHP_DRIVER_UTILS_H
