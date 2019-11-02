<?php

// This source file is part of the polarphp.org open source project
//
// Copyright (c) 2017 - 2019 polarphp software foundation
// Copyright (c) 2017 - 2019 zzu_softboy <zzu_softboy@163.com>
// Licensed under Apache License v2.0 with Runtime Library Exception
//
// See https://polarphp.org/LICENSE.txt for license information
// See https://polarphp.org/CONTRIBUTORS.txt for the list of polarphp project authors
//
// Created by polarboy on 2019/10/29.

$reservedNonModifierTokens = [
   'IncludeKeyword', 'IncludeOnceKeyword', 'EvalKeyword', 'RequireKeyword',
   'RequireOnceKeyword', 'LogicOrKeyword', 'LogicXorKeyword', 'LogicAndKeyword',
   'InstanceofKeyword', 'NewKeyword', 'CloneKeyword', 'ExitKeyword', 'IfKeyword',
   'ElseIfKeyword', 'ElseKeyword', 'EchoKeyword', 'DoKeyword', 'WhileKeyword',
   'ForKeyword', 'ForeachKeyword', 'DeclareKeyword', 'AsKeyword', 'TryKeyword',
   'CatchKeyword', 'FinallyKeyword', 'ThrowKeyword', 'UseKeyword', 'InsteadofKeyword',
   'GlobalKeyword', 'VarKeyword', 'UnsetKeyword', 'IssetKeyword', 'EmptyKeyword',
   'ContinueKeyword', 'GotoKeyword', 'FunctionKeyword', 'ConstKeyword', 'ReturnKeyword',
   'PrintKeyword', 'YieldKeyword', 'ListKeyword', 'SwitchKeyword', 'CaseKeyword',
   'DefaultKeyword', 'BreakKeyword', 'ArrayKeyword', 'CallableKeyword', 'ExtendsKeyword',
   'ImplementsKeyword', 'NamespaceKeyword', 'TraitKeyword', 'InterfaceKeyword', 'ClassKeyword',
   'ClassConstKeyword', 'TraitConstKeyword', 'FuncConstKeyword', 'MethodConstKeyword',
   'LineKeyword', 'FileKeyword', 'DirKeyword', 'NamespaceConstKeyword', 'FnKeyword'
];

$semiReservedTokens = array_merge($reservedNonModifierTokens, [

]);

return array(
   [
      'kind' => 'ReservedNonModifier',
      'baseKind' => 'Syntax',
      'children' => [
         [
            'name' => 'Modifier',
            'kind' => 'Token',
            'tokenChoices' => $reservedNonModifierTokens
         ]
      ]
   ],
   /**
    * semi_reserved:
    *   reserved_non_modifiers
    * | T_STATIC | T_ABSTRACT | T_FINAL | T_PRIVATE | T_PROTECTED | T_PUBLIC
    */
   [
      'kind' => 'SemiReserved',
      'baseKind' => 'Syntax',
      'children' => [
         'name' => 'Modifier',
         'kind' => 'Token',
         'tokenChoices' => $semiReservedTokens
      ]
   ],
   /**
    * identifier:
    *    T_IDENTIFIER_STRING
    *  | semi_reserved
    */
   [
      'kind' => 'Identifier',
      'baseKind' => 'Syntax',
      'children' => [
         'name' => 'NameItem',
         'kind' => 'Syntax',
         'nodeChoices' => [
            ['name' => 'Identifier', 'kind' => 'IdentifierStringToken'],
            ['name' => 'SemiReservedIdentifier', 'kind' => 'SemiReserved']
         ]
      ]
   ],
   /**
    * namespace_name:
    *   T_IDENTIFIER_STRING
    * | namespace_name T_NS_SEPARATOR T_IDENTIFIER_STRING
    */
   [
      'kind' => 'NamespaceName',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'ParentNs', 'kind' => 'NamespaceName'],
         ['name' => 'NsSeparator', 'kind' => 'NamespaceSeparatorToken'],
         ['name' => 'Identifier', 'kind' => 'IdentifierStringToken']
      ]
   ],
   /**
    * name:
    *   namespace_name
    * | T_NAMESPACE T_NS_SEPARATOR namespace_name
    * | T_NS_SEPARATOR namespace_name
    */
   [
      'kind' => 'Name',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'NsKeyword', 'kind' => 'NamespaceKeyword'],
         ['name' => 'NsSeparator', 'kind' => 'NamespaceSeparatorToken'],
         ['name' => 'Namespace', 'kind' => 'NamespaceName']
      ]
   ],
   /**
    * name_list_item:
    *   , name
    */
   [
      'kind' => 'NameListItem',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'Comma', 'kind' => 'CommaToken'],
         ['name' => 'NameRef', 'kind' => 'Name']
      ]
   ],
   /**
    * = expr
    */
   [
      'kind' => 'InitializerClause',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'EqualSign', 'kind' => 'EqualKeyword'],
         ['name' => 'Value', 'kind' => 'Expr']
      ]
   ],
   /**
    * type:
    *   T_ARRAY
    * | T_CALLABLE
    * | name
    */
   [
      'kind' => 'TypeClause',
      'baseKind' => 'Syntax',
      'children' => [
         [
            'name' => 'Type',
            'kind' => 'Token',
            'nodeChoices' => [
               [
                  'name' => 'TokenType',
                  'kind' => 'Token',
                  'tokenChoices' => [
                     'ArrayKeyword',
                     'CallableKeywrd',
                  ]
               ],
               ['name' => 'NameType', 'kind' => 'Name']
            ]
         ]
      ]
   ],
   /**
    * type_expr:
    *   type
    * | '?' type
    */
   [
      'kind' => 'TypeExprClause',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'Question', 'kind' => 'QuestionKeyword'],
         ['name' => 'TypeClause', 'kind' => 'TypeClause']
      ]
   ],
   /**
    * return_type:
    *   ':' type_expr
    */
   [
      'kind' => 'ReturnTypeClause',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'Colon', 'kind' => 'ColonKeyword'],
         ['name' => 'TypeExpr', 'kind' => 'TypeExprClause']
      ]
   ],
   /**
    * parameter:
    *   optional_type is_reference is_variadic T_VARIABLE
    * | optional_type is_reference is_variadic T_VARIABLE '=' expr
    */
   [
      'kind' => 'Parameter',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'TypeHint', 'kind' => 'TypeExprClause', 'isOptional' => true],
         ['name' => 'ReferenceSign', 'kind' => 'AmpersandToken', 'isOptional' => true],
         ['name' => 'VariadicSign', 'kind' => 'EllipsisToken', 'isOptional' => true],
         ['name' => 'Variable', 'kind' => 'VariableToken'],
         ['name' => 'Initializer', 'kind' => 'InitializerClause', 'isOptional' => true]
      ]
   ],
   /**
    * parameter_list_item:
    *   ',' parameter
    */
   [
      'kind' => 'ParameterListItem',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'Comma', 'kind' => 'CommaToken'],
         ['name' => 'Parameter', 'kind' => 'Parameter']
      ]
   ],
   /**
    * parameter_clause:
    *   '(' parameter_list ')'
    */
   [
      'kind' => 'ParameterClause',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'LeftParen', 'kind' => 'LeftParenKeyword'],
         ['name' => 'Parameters', 'kind' => 'ParameterList'],
         ['name' => 'RightParen', 'kind' => 'RightParenKeyword'],
      ]
   ],
   /**
    * function_declaration_statement:
    *   function returns_ref T_STRING backup_doc_comment '(' parameter_list ')' return_type
    *   backup_fn_flags '{' inner_statement_list '}' backup_fn_flags
    */
   [
      'kind' => 'FunctionDefinition',
      'baseKind' => 'Decl',
      'children' => [
         ['name' => 'FuncKeyword', 'kind' => 'FunctionKeyword'],
         ['name' => 'ReturnRef', 'kind' => 'AmpersandToken', 'isOptional' => true],
         ['name' => 'FuncName', 'kind' => 'IdentifierStringKeyword'],
         ['name' => 'ParametersClause', 'kind' => 'ParameterClause'],
         ['name' => 'ReturnTypeClause', 'kind' => 'ReturnTypeClause', 'isOptional' => true],
         ['name' => 'Body', 'kind' => 'InnerCodeBlockStmt']
      ]
   ],
   /**
    * class_modifier:
    *   T_ABSTRACT
    * | T_FINAL
    */
   [
      'kind' => 'ClassModifier',
      'baseKind' => 'Syntax',
      'children' => [
         [
            'name' => 'Modifier',
            'kind' => 'Token',
            'tokenChoices' => [
               'AbstractKeyword',
               'FinalKeyword'
            ]
         ]
      ]
   ],
   /**
    * extends_from:
    *   T_EXTENDS name
    */
   [
      'kind' => 'ExtendsFromClause',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'ExtendsKeyword', 'kind' => 'ExtendsKeyword'],
         ['name' => 'ParentClass', 'kind' => 'Name']
      ]
   ],
   /**
    * implements_list:
    *   T_IMPLEMENTS name_list
    */
   [
      'kind' => 'ImplementsClause',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'ImplementKeyword', 'kind' => 'ImplementsKeyword'],
         ['name' => 'Interfaces', 'kind' => 'NameList']
      ]
   ],
   /**
    * interface_extends_list:
    *   T_EXTENDS name_list
    */
   [
      'kind' => 'InterfaceExtendsClause',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'ExtendsKeyword', 'kind' => 'ExtendsKeyword'],
         ['name' => 'Interfaces', 'kind' => 'NameList']
      ]
   ],
   /**
    * property:
    *   T_VARIABLE backup_doc_comment
    * | T_VARIABLE '=' expr backup_doc_comment
    */
   [
      'kind' => 'ClassPropertyClause',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'Variable', 'kind' => 'VariableToken'],
         ['name' => 'Initializer', 'kind' => 'InitializerClause', 'isOptional' => true]
      ]
   ],
   /**
    * class_property_list_item:
    *   ',' class_property_clause
    * | class_property_clause
    */
   [
      'kind' => 'ClassPropertyListItem',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'Comma', 'kind' => 'CommaToken'],
         ['name' => 'Property', 'kind' => 'ClassPropertyClause']
      ]
   ],
   /**
    * class_const_decl:
    *   identifier '=' expr backup_doc_comment
    */
   [
      'kind' => 'ClassConstClause',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'Identifier', 'kind' => 'Identifier'],
         ['name' => 'Initializer', 'kind' => 'InitializerClause']
      ]
   ],
   /**
    * class_const_list_item:
    *   ',' class_const_clause
    * | class_const_clause
    */
   [
      'kind' => 'ClassConstListItem',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'Comma', 'kind' => 'CommaToken'],
         ['name' => 'ConstDecl', 'kind' => 'ClassConstClause']
      ]
   ],
   /**
    * member_modifier:
    *   T_PUBLIC
    * | T_PROTECTED
    * | T_PRIVATE
    * | T_STATIC
    * | T_ABSTRACT
    * | T_FINAL
    */
   [
      'kind' => 'MemberModifier',
      'baseKind' => 'Syntax',
      'children' => [
         [
            'name' => 'Modifier',
            'kind' => 'Token',
            'tokenChoices' => [
               'PublicKeyword',
               'ProtectedKeyword',
               'PrivateKeyword',
               'StaticKeyword',
               'AbstractKeyword',
               'FinalKeyword'
            ]
         ]
      ]
   ],
   /**
    * class_property_decl:
    *    member_modifiers optional_type property_list
    */
   [
      'kind' => 'ClassPropertyDecl',
      'baseKind' => 'Decl',
      'children' => [
         ['name' => 'Modifiers', 'kind' => 'MemberModifierList'],
         ['name' => 'TypeHint', 'kind' => 'TypeExprClause', 'isOptional' => true],
         ['name' => 'Properties', 'kind' => 'ClassPropertyList']
      ]
   ],
   /**
    * class_statement:
    *   member_modifiers T_CONST class_const_list
    */
   [
      'kind' => 'ClassConstDecl',
      'baseKind' => 'Decl',
      'children' => [
         ['name' => 'Modifiers', 'kind' => 'MemberModifierList'],
         ['name' => 'ConstKeyword', 'kind' => 'ConstKeyword'],
         ['name' => 'ConstList', 'kind' => 'ClassConstList']
      ]
   ],
   /**
    * class_method_statement:
    *   method_modifiers function returns_ref identifier backup_doc_comment '(' parameter_list ')'
    *   return_type backup_fn_flags method_body backup_fn_flags
    */
   [
      'kind' => 'ClassMethodDecl',
      'baseKind' => 'Decl',
      'children' => [
         ['name' => 'Modifiers', 'kind' => 'MemberModifierList'],
         ['name' => 'FunctionKeyword', 'kind' => 'FunctionKeyword'],
         ['name' => 'ReturnRef', 'kind' => 'AmpersandToken'],
         ['name' => 'FuncName', 'kind' => 'Identifier'],
         ['name' => 'ParameterList', 'kind' => 'ParameterClause'],
         ['name' => 'ReturnType', 'kind' => 'ReturnTypeClause', 'isOptional' => true],
         ['name' => 'Body', 'kind' => 'InnerCodeBlockStmt', 'isOptional' => true]
      ]
   ],
   /**
    * trait_method_reference:
    *   identifier
    * | absolute_trait_method_reference
    */
   [
      'kind' => 'ClassTraitMethodReference',
      'baseKind' => 'Syntax',
      'children' => [
         [
            'name' => 'Reference',
            'kind' => 'Syntax',
            'nodeChoices' => [
               ['name' => 'IdentifierRef', 'kind' => 'Identifier'],
               ['name' => 'TraitMenthodRef', 'kind' => 'ClassAbsoluteTraitMethodReference']
            ]
         ]
      ]
   ],
   /**
    * absolute_trait_method_reference:
    *   name T_PAAMAYIM_NEKUDOTAYIM identifier
    */
   [
      'kind' => 'ClassAbsoluteTraitMethodReference',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'BaseName', 'kind' => 'Name'],
         ['name' => 'Separator', 'kind' => 'PaamayimNekudotayimToken'],
         ['name' => 'MemberName', 'kind' => 'Identifier']
      ]
   ],
   /**
    * trait_precedence:
    *    absolute_trait_method_reference T_INSTEADOF name_list
    */
   [
      'kind' => 'ClassTraitPrecedence',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'MethodRef', 'kind' => 'ClassAbsoluteTraitMethodReference'],
         ['name' => 'InsteadOfKeyword', 'kind' => 'InsteadofKeyword'],
         ['name' => 'Names', 'kind' => 'NameList']
      ]
   ],
   /**
    * trait_alias:
    *   trait_method_reference T_AS T_IDENTIFIER_STRING
    * | trait_method_reference T_AS reserved_non_modifiers
    * | trait_method_reference T_AS member_modifier identifier
    * | trait_method_reference T_AS member_modifier
    */
   [
      'kind' => 'ClassTraitAlias',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'MethodRef', 'kind' => 'ClassTraitMethodReference'],
         ['name' => 'As', 'kind' => 'AsKeyword'],
         [
            'name' => 'Modifier',
            'kind' => 'Syntax',
            'nodeChoices' => [
               ['name' => 'ReservedNonModifier', 'kind' => 'ReservedNonModifier'],
               ['name' => 'MemberModifier', 'kind' => 'MemberModifier']
            ]
         ],
         [
            'name' => 'AliasName',
            'kind' => 'Syntax',
            'nodeChoices' => [
               ['name' => 'IdentifierStringAlias', 'kind' => 'IdentifierStringToken'],
               ['name' => 'IdentifierAlias', 'kind' => 'Identifier']
            ]
         ]
      ]
   ],
   /**
    * trait_adaptation:
    *   trait_precedence ';'
    * | trait_alias ';'
    */
   [
      'kind' => 'ClassTraitAdaptation',
      'baseKind' => 'Syntax',
      'children' => [
         [
            'name' => 'Adaptation',
            'kind' => 'Syntax',
            'nodeChoices' => [
               ['name' => 'ClassTraitPrecedenceAdaption', 'kind' => 'ClassTraitPrecedence'],
               ['name' => 'ClassTraitAliasAdaption', 'kind' => 'ClassTraitAlias']
            ]
         ],
         ['name' => 'Semicolon', 'kind' => 'SemicolonToken']
      ]
   ],
   /**
    * trait_adaptations:
    * ';'
    * | '{' '}'
    * | '{' trait_adaptation_list '}'
    */
   [
      'kind' => 'ClassTraitAdaptationBlock',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'LeftBrace', 'kind' => 'LeftParenToken'],
         ['name' => 'Adaptations', 'kind' => 'ClassTraitAdaptationList'],
         ['name' => 'RightBrace', 'kind' => 'RightParenToken']
      ]
   ],
   /**
    * class_statement:
    *   T_USE name_list trait_adaptations
    */
   [
      'kind' => 'ClassTraitDecl',
      'baseKind' => 'Decl',
      'children' => [
         ['name' => 'UseKeyword', 'kind' => 'UseKeyword'],
         ['name' => 'Names', 'kind' => 'NameList'],
         ['name' => 'AdaptationBlock', 'kind' => 'ClassTraitAdaptationBlock', 'isOptional' => true]
      ]
   ],
   /**
    * member-decl:
    *   decl ';'?
    */
   [
      'kind' => 'MemberDeclListItem',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'MemberDecl', 'kind' => 'Decl'],
         ['name' => 'Semicolon', 'kind' => 'SemicolonToken', 'isOptional' => true]
      ]
   ],
   /**
    * member_decl_block:
    * '{' class_statement_list '}'
    */
   [
      'kind' => 'MemberDeclBlock',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'LeftBrace', 'kind' => 'LeftBraceToken'],
         ['name' => 'Members', 'kind' => 'MemberDeclList'],
         ['name' => 'RightBrace', 'kind' => 'RightBraceToken']
      ]
   ],
   /**
    * class_declaration_statement:
    *   class_modifiers T_CLASS T_IDENTIFIER_STRING extends_from implements_list backup_doc_comment '{' class_statement_list '}'
    * | T_CLASS T_STRING extends_from implements_list backup_doc_comment '{' class_statement_list '}'
    */
   [
      'kind' => 'ClassDefinition',
      'baseKind' => 'Decl',
      'children' => [
         ['name' => 'Modififers', 'kind' => 'ClassModifierList', 'isOptional' => true],
         ['name' => 'ClassKeyword', 'kind' => 'ClassKeyword'],
         ['name' => 'Name', 'kind' => 'IdentifierStringToken'],
         ['name' => 'ExtendsFrom', 'kind' => 'ExtendsFromClause', 'isOptional' => true],
         ['name' => 'Implements', 'kind' => 'ImplementsClause', 'isOptional' => true],
         ['name' => 'Members', 'kind' => 'MemberDeclBlock']
      ]
   ],
   /**
    * interface_declaration_statement:
    *   T_INTERFACE T_IDENTIFIER_STRING interface_extends_list backup_doc_comment '{' class_statement_list '}'
    */
   [
      'kind' => 'InterfaceDefinition',
      'baseKind' => 'Decl',
      'children' => [
         ['name' => 'InterfaceKeyword', 'kind' => 'InterfaceKeyword'],
         ['name' => 'Name', 'kind' => 'IdentifierStringToken'],
         ['name' => 'ExtendsFrom', 'kind' => 'ExtendsFromKeyword', 'isOptional' => true],
         ['name' => 'Members', 'kind' => 'MemberDeclBlock']
      ]
   ],
   /**
    * trait_declaration_statement:
    * T_TRAIT T_IDENTIFIER_STRING backup_doc_comment '{' class_statement_list '}'
    */
   [
      'kind' => 'TraitDefinition',
      'baseKind' => 'Decl',
      'children' => [
         ['name' => 'TraitKeyword', 'kind' => 'TraitKeyword'],
         ['name' => 'Name', 'kind' => 'IdentifierStringToken'],
         ['name' => 'Members', 'kind' => 'MemberDeclBlock']
      ]
   ],
   /**
    * sourcefile:
    *   topstmts EOFToken
    */
   [
      'kind' => 'SourceFile',
      'baseKind' => 'Syntax',
      'children' => [
         ['name' => 'Statements', 'kind' => 'TopStmtList'],
         ['name' => 'EOF', 'kind' => 'EndToken']
      ]
   ]
);